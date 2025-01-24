<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\ClickTrackingDto;
use App\Jobs\TrackLinkClickJob;
use App\Repositories\Contracts\LinkRepositoryInterface;
use App\ValueObjects\ShortCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class RedirectLinkController extends Controller
{
    public function __construct(
        private readonly LinkRepositoryInterface $linkRepository
    ){}

    public function __invoke(string $shortCode, Request $request): RedirectResponse|Response
    {
        try {
            $code = ShortCode::fromString($shortCode);
            $link = $this->linkRepository->findByShortCode($code);

            if (!$link) {
                throw new ModelNotFoundException();
            }

            $clickTracking = new ClickTrackingDto(
                $request->ip(),
                $request->userAgent()
            );

            dispatch(new TrackLinkClickJob($link->getKey(), $clickTracking));

            return redirect($link->url);
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage(), [
                'short_code' => $shortCode
            ]);

            abort(400);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage(), [
                'short_code' => $shortCode,
            ]);

            abort(404);
        }
    }
}

<?php declare(strict_types=1);

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Repositories\Contracts\LinkClickRepositoryInterface;
use App\Repositories\Contracts\LinkRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class LinkController extends Controller
{
    public function __construct(
        private readonly LinkRepositoryInterface $linkRepository,
        private readonly LinkClickRepositoryInterface $linkClickRepository
    ){}

    public function index(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', Link::class);

        $userId = $request->user()->getKey();
        $links = $this->linkRepository->getUserLinks($userId);

        return response()->json(
            data: [
                'links' => LinkResource::collection($links)
            ]
        );
    }

    public function store(CreateLinkRequest $request): JsonResponse
    {
        Gate::authorize('create', Link::class);

        $createLinkDto = $request->getLink();
        $link = $this->linkRepository->create($createLinkDto);

        return response()->json(
            data: [
                'link_id' => $link->getKey()
            ]
        );
    }

    public function show(int $linkId): JsonResponse
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('view', $link);

        $statistics = [
            'total_clicks' => $this->linkClickRepository->getTotalClicks($linkId),
            'clicks_by_period' => $this->linkClickRepository->getClicksByPeriod($linkId),
            'clicks_by_country' => $this->linkClickRepository->getClicksByCountry($linkId),
            'clicks_by_device' => $this->linkClickRepository->getClicksByDevice($linkId),
            'clicks_by_browser' => $this->linkClickRepository->getClicksByBrowser($linkId)
        ];

        return response()->json(
            data: [
                'link' => new LinkResource($link),
                'statistics' => $statistics
            ]
        );
    }

    public function update(int $linkId, UpdateLinkRequest $request): Response
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('update', $link);

        $updateLinkDto = $request->getLink();
        $this->linkRepository->update($link->getKey(), $updateLinkDto);

        return response()->noContent();
    }

    public function destroy(int $linkId): Response
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('delete', $link);

        $this->linkRepository->delete($linkId);

        return response()->noContent();
    }

    public function statistics(int $linkId): JsonResponse
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('view', $link);

        $statistics = [
            'total_clicks' => $this->linkClickRepository->getTotalClicks($linkId),
            'clicks_by_period' => $this->linkClickRepository->getClicksByPeriod($linkId),
            'clicks_by_country' => $this->linkClickRepository->getClicksByCountry($linkId),
            'clicks_by_device' => $this->linkClickRepository->getClicksByDevice($linkId),
            'clicks_by_browser' => $this->linkClickRepository->getClicksByBrowser($linkId)
        ];

        return response()->json(
            data: [
                'statistics' => $statistics
            ]
        );
    }
}

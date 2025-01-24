<?php declare(strict_types=1);

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Repositories\Contracts\LinkClickRepositoryInterface;
use App\Repositories\Contracts\LinkRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Response as InertiaResponse;

class LinkController extends Controller
{
    public function __construct(
        private readonly LinkRepositoryInterface $linkRepository,
        private readonly LinkClickRepositoryInterface $linkClickRepository
    ){}

    public function index(Request $request): InertiaResponse
    {
        Gate::authorize('viewAny', Link::class);

        $userId = $request->user()->getKey();
        $links = $this->linkRepository->getUserLinks($userId);

        return inertia('Link/Index', [
            'links' => LinkResource::collection($links)
        ]);
    }

    public function create(): InertiaResponse
    {
        Gate::authorize('create', Link::class);

        return inertia('Link/Create');
    }

    public function store(CreateLinkRequest $request): RedirectResponse
    {
        Gate::authorize('create', Link::class);

        $createLinkDto = $request->getLink();
        $this->linkRepository->create($createLinkDto);

        return redirect()->route('links.index');
    }

    public function show(int $linkId): InertiaResponse
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

        return inertia('Link/Show', [
            'link' => new LinkResource($link),
            'statistics' => $statistics
        ]);
    }

    public function edit(int $linkId): InertiaResponse
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('update', $link);

        return inertia('Link/Edit', [
            'link' => new LinkResource($link)
        ]);
    }

    public function update(int $linkId, UpdateLinkRequest $request): RedirectResponse
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('update', $link);

        $updateLinkDto = $request->getLink();
        $this->linkRepository->update($link->getKey(), $updateLinkDto);

        return redirect()->route('links.show', $linkId);
    }

    public function destroy(int $linkId): RedirectResponse
    {
        $link = $this->linkRepository->findById($linkId);

        Gate::authorize('delete', $link);

        $this->linkRepository->delete($linkId);

        return redirect()->route('links.index');
    }
}

<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'title' => $this->resource->title ?? $this->resource->url,
            'short_code' => [
                'code' => $this->resource->short_code,
                'url' => route('links.redirect', $this->resource->short_code),
            ],
            'url' => $this->resource->url,
            'created_at' => new DateTimeResource($this->resource->created_at),
        ];
    }
}

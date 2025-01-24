<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateTimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'datetime' => $this->resource->toISOString(),
            'human_diff' => $this->resource->diffForHumans(),
            'human' => $this->resource->toDayDateTimeString(),
        ];
    }
}

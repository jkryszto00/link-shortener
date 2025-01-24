<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkClick extends Model
{
    protected $fillable = [
        'link_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'browser',
        'browser_version',
        'platform',
        'platform_version',
        'device_type',
        'device_name'
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}

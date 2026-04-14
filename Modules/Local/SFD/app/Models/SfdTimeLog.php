<?php

namespace Modules\SFD\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SFD\Database\Factories\SfdTimeLogFactory;

class SfdTimeLog extends Model
{
    use HasFactory;

    protected $table = 'sfd_time_logs';

    protected $fillable = [
        'work_order_id',
        'user_id',
        'started_at',
        'ended_at',
        'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    protected static function newFactory(): SfdTimeLogFactory
    {
        return SfdTimeLogFactory::new();
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(SfdWorkOrder::class, 'work_order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

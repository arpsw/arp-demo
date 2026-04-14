<?php

namespace Modules\SFD\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SFD\Database\Factories\SfdQualityCheckFactory;
use Modules\SFD\Enums\QualityCheckResult;
use Modules\SFD\Enums\QualityCheckType;

class SfdQualityCheck extends Model
{
    use HasFactory;

    protected $table = 'sfd_quality_checks';

    protected $fillable = [
        'work_order_id',
        'name',
        'type',
        'result',
        'measured_value',
        'notes',
        'checked_by',
        'checked_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'type' => QualityCheckType::class,
            'result' => QualityCheckResult::class,
            'checked_at' => 'datetime',
        ];
    }

    protected static function newFactory(): SfdQualityCheckFactory
    {
        return SfdQualityCheckFactory::new();
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(SfdWorkOrder::class, 'work_order_id');
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}

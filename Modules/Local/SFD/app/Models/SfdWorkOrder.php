<?php

namespace Modules\SFD\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Ai\Automation\HasAIAutomation;
use Modules\SFD\Database\Factories\SfdWorkOrderFactory;
use Modules\SFD\Enums\WorkOrderStatus;

class SfdWorkOrder extends Model
{
    use HasAIAutomation;
    use HasFactory;

    protected $table = 'sfd_work_orders';

    protected $fillable = [
        'manufacturing_order_id',
        'operation_id',
        'work_center_id',
        'name',
        'status',
        'expected_duration',
        'actual_duration',
        'started_at',
        'completed_at',
        'assigned_to',
        'sort_order',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => WorkOrderStatus::class,
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    protected static function newFactory(): SfdWorkOrderFactory
    {
        return SfdWorkOrderFactory::new();
    }

    public static function getAutomationLabel(): string
    {
        return 'Work Order (SFD)';
    }

    public function toAutomationArray(): array
    {
        $this->loadMissing([
            'workCenter.equipment.category',
            'workCenter.equipment.technician',
            'manufacturingOrder',
            'operation',
            'assignedUser',
        ]);

        $data = $this->toArray();

        if ($this->workCenter) {
            $data['work_center'] = [
                'id' => $this->workCenter->id,
                'name' => $this->workCenter->name,
                'code' => $this->workCenter->code,
                'equipment' => $this->workCenter->equipment->map(fn ($eq) => [
                    'id' => $eq->id,
                    'name' => $eq->name,
                    'serial_number' => $eq->serial_number,
                    'status' => $eq->status?->value,
                    'category' => $eq->category?->name,
                    'technician' => $eq->technician?->name,
                    'technician_id' => $eq->technician_id,
                    'location' => $eq->location,
                ])->toArray(),
            ];
        }

        return $data;
    }

    public function manufacturingOrder(): BelongsTo
    {
        return $this->belongsTo(SfdManufacturingOrder::class, 'manufacturing_order_id');
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(SfdOperation::class, 'operation_id');
    }

    public function workCenter(): BelongsTo
    {
        return $this->belongsTo(SfdWorkCenter::class, 'work_center_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function qualityChecks(): HasMany
    {
        return $this->hasMany(SfdQualityCheck::class, 'work_order_id');
    }

    public function timeLogs(): HasMany
    {
        return $this->hasMany(SfdTimeLog::class, 'work_order_id');
    }
}

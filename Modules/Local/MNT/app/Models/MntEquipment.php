<?php

namespace Modules\MNT\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\MNT\Database\Factories\MntEquipmentFactory;
use Modules\MNT\Enums\EquipmentStatus;
use Modules\SFD\Models\SfdWorkCenter;

class MntEquipment extends Model
{
    use HasFactory;

    protected $table = 'mnt_equipment';

    protected $fillable = [
        'name',
        'serial_number',
        'category_id',
        'work_center_id',
        'technician_id',
        'owner_id',
        'location',
        'model',
        'manufacturer',
        'purchase_date',
        'warranty_expiry',
        'cost',
        'notes',
        'effective_date',
        'status',
        'mtbf',
        'mttr',
        'expected_mtbf',
        'latest_failure_date',
        'next_preventive_date',
    ];

    protected function casts(): array
    {
        return [
            'status' => EquipmentStatus::class,
            'cost' => 'decimal:2',
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
            'effective_date' => 'date',
            'latest_failure_date' => 'date',
            'next_preventive_date' => 'date',
        ];
    }

    protected static function newFactory(): MntEquipmentFactory
    {
        return MntEquipmentFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MntEquipmentCategory::class, 'category_id');
    }

    public function workCenter(): BelongsTo
    {
        return $this->belongsTo(SfdWorkCenter::class, 'work_center_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MntMaintenanceRequest::class, 'equipment_id');
    }

    public function preventiveSchedules(): HasMany
    {
        return $this->hasMany(MntPreventiveSchedule::class, 'equipment_id');
    }
}

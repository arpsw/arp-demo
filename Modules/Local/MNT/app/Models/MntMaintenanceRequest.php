<?php

namespace Modules\MNT\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\MNT\Database\Factories\MntMaintenanceRequestFactory;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;

class MntMaintenanceRequest extends Model
{
    use HasFactory;

    protected $table = 'mnt_maintenance_requests';

    protected $fillable = [
        'reference',
        'name',
        'equipment_id',
        'category_id',
        'request_type',
        'priority',
        'stage',
        'team_id',
        'technician_id',
        'requested_by',
        'scheduled_date',
        'close_date',
        'duration',
        'description',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'request_type' => MaintenanceRequestType::class,
            'priority' => MaintenancePriority::class,
            'stage' => MaintenanceStage::class,
            'scheduled_date' => 'date',
            'close_date' => 'date',
            'duration' => 'decimal:2',
        ];
    }

    protected static function newFactory(): MntMaintenanceRequestFactory
    {
        return MntMaintenanceRequestFactory::new();
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(MntEquipment::class, 'equipment_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MntEquipmentCategory::class, 'category_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(MntMaintenanceTeam::class, 'team_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}

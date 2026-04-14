<?php

namespace Modules\MNT\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\MNT\Database\Factories\MntPreventiveScheduleFactory;
use Modules\MNT\Enums\MaintenancePriority;

class MntPreventiveSchedule extends Model
{
    use HasFactory;

    protected $table = 'mnt_preventive_schedules';

    protected $fillable = [
        'equipment_id',
        'name',
        'frequency_days',
        'team_id',
        'technician_id',
        'priority',
        'description',
        'last_generated_date',
        'next_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'priority' => MaintenancePriority::class,
            'last_generated_date' => 'date',
            'next_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): MntPreventiveScheduleFactory
    {
        return MntPreventiveScheduleFactory::new();
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(MntEquipment::class, 'equipment_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(MntMaintenanceTeam::class, 'team_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}

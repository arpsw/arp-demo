<?php

namespace Modules\MNT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\MNT\Database\Factories\MntMaintenanceTeamFactory;

class MntMaintenanceTeam extends Model
{
    use HasFactory;

    protected $table = 'mnt_maintenance_teams';

    protected $fillable = [
        'name',
        'color',
        'company',
        'notes',
    ];

    protected static function newFactory(): MntMaintenanceTeamFactory
    {
        return MntMaintenanceTeamFactory::new();
    }

    public function members(): HasMany
    {
        return $this->hasMany(MntMaintenanceTeamMember::class, 'team_id');
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MntMaintenanceRequest::class, 'team_id');
    }

    public function preventiveSchedules(): HasMany
    {
        return $this->hasMany(MntPreventiveSchedule::class, 'team_id');
    }
}

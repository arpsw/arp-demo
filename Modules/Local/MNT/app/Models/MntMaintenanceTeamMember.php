<?php

namespace Modules\MNT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\MNT\Database\Factories\MntMaintenanceTeamMemberFactory;
use Modules\MNT\Enums\TeamMemberRole;

class MntMaintenanceTeamMember extends Model
{
    use HasFactory;

    protected $table = 'mnt_maintenance_team_members';

    protected $fillable = [
        'team_id',
        'first_name',
        'last_name',
        'phone',
        'role',
    ];

    protected function casts(): array
    {
        return [
            'role' => TeamMemberRole::class,
        ];
    }

    protected static function newFactory(): MntMaintenanceTeamMemberFactory
    {
        return MntMaintenanceTeamMemberFactory::new();
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(MntMaintenanceTeam::class, 'team_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

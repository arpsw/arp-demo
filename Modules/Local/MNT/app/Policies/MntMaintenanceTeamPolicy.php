<?php

declare(strict_types=1);

namespace Modules\MNT\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\MNT\Models\MntMaintenanceTeam;
use Illuminate\Auth\Access\HandlesAuthorization;

class MntMaintenanceTeamPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MntMaintenanceTeam');
    }

    public function view(AuthUser $authUser, MntMaintenanceTeam $mntMaintenanceTeam): bool
    {
        return $authUser->can('View:MntMaintenanceTeam');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MntMaintenanceTeam');
    }

    public function update(AuthUser $authUser, MntMaintenanceTeam $mntMaintenanceTeam): bool
    {
        return $authUser->can('Update:MntMaintenanceTeam');
    }

    public function delete(AuthUser $authUser, MntMaintenanceTeam $mntMaintenanceTeam): bool
    {
        return $authUser->can('Delete:MntMaintenanceTeam');
    }

    public function restore(AuthUser $authUser, MntMaintenanceTeam $mntMaintenanceTeam): bool
    {
        return $authUser->can('Restore:MntMaintenanceTeam');
    }

    public function forceDelete(AuthUser $authUser, MntMaintenanceTeam $mntMaintenanceTeam): bool
    {
        return $authUser->can('ForceDelete:MntMaintenanceTeam');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MntMaintenanceTeam');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MntMaintenanceTeam');
    }

    public function replicate(AuthUser $authUser, MntMaintenanceTeam $mntMaintenanceTeam): bool
    {
        return $authUser->can('Replicate:MntMaintenanceTeam');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MntMaintenanceTeam');
    }

}
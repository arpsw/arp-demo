<?php

declare(strict_types=1);

namespace Modules\MNT\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\MNT\Models\MntMaintenanceRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class MntMaintenanceRequestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MntMaintenanceRequest');
    }

    public function view(AuthUser $authUser, MntMaintenanceRequest $mntMaintenanceRequest): bool
    {
        return $authUser->can('View:MntMaintenanceRequest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MntMaintenanceRequest');
    }

    public function update(AuthUser $authUser, MntMaintenanceRequest $mntMaintenanceRequest): bool
    {
        return $authUser->can('Update:MntMaintenanceRequest');
    }

    public function delete(AuthUser $authUser, MntMaintenanceRequest $mntMaintenanceRequest): bool
    {
        return $authUser->can('Delete:MntMaintenanceRequest');
    }

    public function restore(AuthUser $authUser, MntMaintenanceRequest $mntMaintenanceRequest): bool
    {
        return $authUser->can('Restore:MntMaintenanceRequest');
    }

    public function forceDelete(AuthUser $authUser, MntMaintenanceRequest $mntMaintenanceRequest): bool
    {
        return $authUser->can('ForceDelete:MntMaintenanceRequest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MntMaintenanceRequest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MntMaintenanceRequest');
    }

    public function replicate(AuthUser $authUser, MntMaintenanceRequest $mntMaintenanceRequest): bool
    {
        return $authUser->can('Replicate:MntMaintenanceRequest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MntMaintenanceRequest');
    }

}
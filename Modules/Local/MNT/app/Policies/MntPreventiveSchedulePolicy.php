<?php

declare(strict_types=1);

namespace Modules\MNT\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\MNT\Models\MntPreventiveSchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class MntPreventiveSchedulePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MntPreventiveSchedule');
    }

    public function view(AuthUser $authUser, MntPreventiveSchedule $mntPreventiveSchedule): bool
    {
        return $authUser->can('View:MntPreventiveSchedule');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MntPreventiveSchedule');
    }

    public function update(AuthUser $authUser, MntPreventiveSchedule $mntPreventiveSchedule): bool
    {
        return $authUser->can('Update:MntPreventiveSchedule');
    }

    public function delete(AuthUser $authUser, MntPreventiveSchedule $mntPreventiveSchedule): bool
    {
        return $authUser->can('Delete:MntPreventiveSchedule');
    }

    public function restore(AuthUser $authUser, MntPreventiveSchedule $mntPreventiveSchedule): bool
    {
        return $authUser->can('Restore:MntPreventiveSchedule');
    }

    public function forceDelete(AuthUser $authUser, MntPreventiveSchedule $mntPreventiveSchedule): bool
    {
        return $authUser->can('ForceDelete:MntPreventiveSchedule');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MntPreventiveSchedule');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MntPreventiveSchedule');
    }

    public function replicate(AuthUser $authUser, MntPreventiveSchedule $mntPreventiveSchedule): bool
    {
        return $authUser->can('Replicate:MntPreventiveSchedule');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MntPreventiveSchedule');
    }

}
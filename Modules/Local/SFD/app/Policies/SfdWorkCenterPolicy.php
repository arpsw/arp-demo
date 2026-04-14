<?php

declare(strict_types=1);

namespace Modules\SFD\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\SFD\Models\SfdWorkCenter;
use Illuminate\Auth\Access\HandlesAuthorization;

class SfdWorkCenterPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SfdWorkCenter');
    }

    public function view(AuthUser $authUser, SfdWorkCenter $sfdWorkCenter): bool
    {
        return $authUser->can('View:SfdWorkCenter');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SfdWorkCenter');
    }

    public function update(AuthUser $authUser, SfdWorkCenter $sfdWorkCenter): bool
    {
        return $authUser->can('Update:SfdWorkCenter');
    }

    public function delete(AuthUser $authUser, SfdWorkCenter $sfdWorkCenter): bool
    {
        return $authUser->can('Delete:SfdWorkCenter');
    }

    public function restore(AuthUser $authUser, SfdWorkCenter $sfdWorkCenter): bool
    {
        return $authUser->can('Restore:SfdWorkCenter');
    }

    public function forceDelete(AuthUser $authUser, SfdWorkCenter $sfdWorkCenter): bool
    {
        return $authUser->can('ForceDelete:SfdWorkCenter');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SfdWorkCenter');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SfdWorkCenter');
    }

    public function replicate(AuthUser $authUser, SfdWorkCenter $sfdWorkCenter): bool
    {
        return $authUser->can('Replicate:SfdWorkCenter');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SfdWorkCenter');
    }

}
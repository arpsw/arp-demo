<?php

declare(strict_types=1);

namespace Modules\SFD\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\SFD\Models\SfdWorkOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class SfdWorkOrderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SfdWorkOrder');
    }

    public function view(AuthUser $authUser, SfdWorkOrder $sfdWorkOrder): bool
    {
        return $authUser->can('View:SfdWorkOrder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SfdWorkOrder');
    }

    public function update(AuthUser $authUser, SfdWorkOrder $sfdWorkOrder): bool
    {
        return $authUser->can('Update:SfdWorkOrder');
    }

    public function delete(AuthUser $authUser, SfdWorkOrder $sfdWorkOrder): bool
    {
        return $authUser->can('Delete:SfdWorkOrder');
    }

    public function restore(AuthUser $authUser, SfdWorkOrder $sfdWorkOrder): bool
    {
        return $authUser->can('Restore:SfdWorkOrder');
    }

    public function forceDelete(AuthUser $authUser, SfdWorkOrder $sfdWorkOrder): bool
    {
        return $authUser->can('ForceDelete:SfdWorkOrder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SfdWorkOrder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SfdWorkOrder');
    }

    public function replicate(AuthUser $authUser, SfdWorkOrder $sfdWorkOrder): bool
    {
        return $authUser->can('Replicate:SfdWorkOrder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SfdWorkOrder');
    }

}
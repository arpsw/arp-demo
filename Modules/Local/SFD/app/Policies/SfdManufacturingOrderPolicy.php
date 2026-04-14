<?php

declare(strict_types=1);

namespace Modules\SFD\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\SFD\Models\SfdManufacturingOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class SfdManufacturingOrderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SfdManufacturingOrder');
    }

    public function view(AuthUser $authUser, SfdManufacturingOrder $sfdManufacturingOrder): bool
    {
        return $authUser->can('View:SfdManufacturingOrder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SfdManufacturingOrder');
    }

    public function update(AuthUser $authUser, SfdManufacturingOrder $sfdManufacturingOrder): bool
    {
        return $authUser->can('Update:SfdManufacturingOrder');
    }

    public function delete(AuthUser $authUser, SfdManufacturingOrder $sfdManufacturingOrder): bool
    {
        return $authUser->can('Delete:SfdManufacturingOrder');
    }

    public function restore(AuthUser $authUser, SfdManufacturingOrder $sfdManufacturingOrder): bool
    {
        return $authUser->can('Restore:SfdManufacturingOrder');
    }

    public function forceDelete(AuthUser $authUser, SfdManufacturingOrder $sfdManufacturingOrder): bool
    {
        return $authUser->can('ForceDelete:SfdManufacturingOrder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SfdManufacturingOrder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SfdManufacturingOrder');
    }

    public function replicate(AuthUser $authUser, SfdManufacturingOrder $sfdManufacturingOrder): bool
    {
        return $authUser->can('Replicate:SfdManufacturingOrder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SfdManufacturingOrder');
    }

}
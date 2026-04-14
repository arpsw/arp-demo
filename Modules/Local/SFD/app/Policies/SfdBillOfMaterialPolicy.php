<?php

declare(strict_types=1);

namespace Modules\SFD\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\SFD\Models\SfdBillOfMaterial;
use Illuminate\Auth\Access\HandlesAuthorization;

class SfdBillOfMaterialPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SfdBillOfMaterial');
    }

    public function view(AuthUser $authUser, SfdBillOfMaterial $sfdBillOfMaterial): bool
    {
        return $authUser->can('View:SfdBillOfMaterial');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SfdBillOfMaterial');
    }

    public function update(AuthUser $authUser, SfdBillOfMaterial $sfdBillOfMaterial): bool
    {
        return $authUser->can('Update:SfdBillOfMaterial');
    }

    public function delete(AuthUser $authUser, SfdBillOfMaterial $sfdBillOfMaterial): bool
    {
        return $authUser->can('Delete:SfdBillOfMaterial');
    }

    public function restore(AuthUser $authUser, SfdBillOfMaterial $sfdBillOfMaterial): bool
    {
        return $authUser->can('Restore:SfdBillOfMaterial');
    }

    public function forceDelete(AuthUser $authUser, SfdBillOfMaterial $sfdBillOfMaterial): bool
    {
        return $authUser->can('ForceDelete:SfdBillOfMaterial');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SfdBillOfMaterial');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SfdBillOfMaterial');
    }

    public function replicate(AuthUser $authUser, SfdBillOfMaterial $sfdBillOfMaterial): bool
    {
        return $authUser->can('Replicate:SfdBillOfMaterial');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SfdBillOfMaterial');
    }

}
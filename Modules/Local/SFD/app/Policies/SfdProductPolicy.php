<?php

declare(strict_types=1);

namespace Modules\SFD\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\SFD\Models\SfdProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class SfdProductPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SfdProduct');
    }

    public function view(AuthUser $authUser, SfdProduct $sfdProduct): bool
    {
        return $authUser->can('View:SfdProduct');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SfdProduct');
    }

    public function update(AuthUser $authUser, SfdProduct $sfdProduct): bool
    {
        return $authUser->can('Update:SfdProduct');
    }

    public function delete(AuthUser $authUser, SfdProduct $sfdProduct): bool
    {
        return $authUser->can('Delete:SfdProduct');
    }

    public function restore(AuthUser $authUser, SfdProduct $sfdProduct): bool
    {
        return $authUser->can('Restore:SfdProduct');
    }

    public function forceDelete(AuthUser $authUser, SfdProduct $sfdProduct): bool
    {
        return $authUser->can('ForceDelete:SfdProduct');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SfdProduct');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SfdProduct');
    }

    public function replicate(AuthUser $authUser, SfdProduct $sfdProduct): bool
    {
        return $authUser->can('Replicate:SfdProduct');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SfdProduct');
    }

}
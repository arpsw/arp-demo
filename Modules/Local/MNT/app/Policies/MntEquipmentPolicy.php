<?php

declare(strict_types=1);

namespace Modules\MNT\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\MNT\Models\MntEquipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class MntEquipmentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MntEquipment');
    }

    public function view(AuthUser $authUser, MntEquipment $mntEquipment): bool
    {
        return $authUser->can('View:MntEquipment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MntEquipment');
    }

    public function update(AuthUser $authUser, MntEquipment $mntEquipment): bool
    {
        return $authUser->can('Update:MntEquipment');
    }

    public function delete(AuthUser $authUser, MntEquipment $mntEquipment): bool
    {
        return $authUser->can('Delete:MntEquipment');
    }

    public function restore(AuthUser $authUser, MntEquipment $mntEquipment): bool
    {
        return $authUser->can('Restore:MntEquipment');
    }

    public function forceDelete(AuthUser $authUser, MntEquipment $mntEquipment): bool
    {
        return $authUser->can('ForceDelete:MntEquipment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MntEquipment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MntEquipment');
    }

    public function replicate(AuthUser $authUser, MntEquipment $mntEquipment): bool
    {
        return $authUser->can('Replicate:MntEquipment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MntEquipment');
    }

}
<?php

declare(strict_types=1);

namespace Modules\MNT\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\MNT\Models\MntEquipmentCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class MntEquipmentCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MntEquipmentCategory');
    }

    public function view(AuthUser $authUser, MntEquipmentCategory $mntEquipmentCategory): bool
    {
        return $authUser->can('View:MntEquipmentCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MntEquipmentCategory');
    }

    public function update(AuthUser $authUser, MntEquipmentCategory $mntEquipmentCategory): bool
    {
        return $authUser->can('Update:MntEquipmentCategory');
    }

    public function delete(AuthUser $authUser, MntEquipmentCategory $mntEquipmentCategory): bool
    {
        return $authUser->can('Delete:MntEquipmentCategory');
    }

    public function restore(AuthUser $authUser, MntEquipmentCategory $mntEquipmentCategory): bool
    {
        return $authUser->can('Restore:MntEquipmentCategory');
    }

    public function forceDelete(AuthUser $authUser, MntEquipmentCategory $mntEquipmentCategory): bool
    {
        return $authUser->can('ForceDelete:MntEquipmentCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MntEquipmentCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MntEquipmentCategory');
    }

    public function replicate(AuthUser $authUser, MntEquipmentCategory $mntEquipmentCategory): bool
    {
        return $authUser->can('Replicate:MntEquipmentCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MntEquipmentCategory');
    }

}
<?php

namespace Modules\MNT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\MNT\Database\Factories\MntEquipmentCategoryFactory;

class MntEquipmentCategory extends Model
{
    use HasFactory;

    protected $table = 'mnt_equipment_categories';

    protected $fillable = [
        'name',
        'color',
        'notes',
    ];

    protected static function newFactory(): MntEquipmentCategoryFactory
    {
        return MntEquipmentCategoryFactory::new();
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(MntEquipment::class, 'category_id');
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MntMaintenanceRequest::class, 'category_id');
    }
}

<?php

namespace Modules\SFD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\MNT\Models\MntEquipment;
use Modules\SFD\Database\Factories\SfdWorkCenterFactory;

class SfdWorkCenter extends Model
{
    use HasFactory;

    protected $table = 'sfd_work_centers';

    protected $fillable = [
        'name',
        'code',
        'capacity',
        'cost_per_hour',
        'time_before_production',
        'time_after_production',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'cost_per_hour' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): SfdWorkCenterFactory
    {
        return SfdWorkCenterFactory::new();
    }

    public function operations(): HasMany
    {
        return $this->hasMany(SfdOperation::class, 'work_center_id');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(SfdWorkOrder::class, 'work_center_id');
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(MntEquipment::class, 'work_center_id');
    }
}

<?php

namespace Modules\SFD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\SFD\Database\Factories\SfdProductFactory;
use Modules\SFD\Enums\ProductType;

class SfdProduct extends Model
{
    use HasFactory;

    protected $table = 'sfd_products';

    protected $fillable = [
        'name',
        'sku',
        'type',
        'description',
        'unit_cost',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'type' => ProductType::class,
            'unit_cost' => 'decimal:2',
        ];
    }

    protected static function newFactory(): SfdProductFactory
    {
        return SfdProductFactory::new();
    }

    public function billOfMaterials(): HasMany
    {
        return $this->hasMany(SfdBillOfMaterial::class, 'product_id');
    }

    public function usedInComponents(): HasMany
    {
        return $this->hasMany(SfdBomComponent::class, 'product_id');
    }

    public function manufacturingOrders(): HasMany
    {
        return $this->hasMany(SfdManufacturingOrder::class, 'product_id');
    }
}

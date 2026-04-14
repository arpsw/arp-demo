<?php

namespace Modules\SFD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\SFD\Database\Factories\SfdBillOfMaterialFactory;

class SfdBillOfMaterial extends Model
{
    use HasFactory;

    protected $table = 'sfd_bill_of_materials';

    protected $fillable = [
        'product_id',
        'name',
        'quantity',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): SfdBillOfMaterialFactory
    {
        return SfdBillOfMaterialFactory::new();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(SfdProduct::class, 'product_id');
    }

    public function components(): HasMany
    {
        return $this->hasMany(SfdBomComponent::class, 'bom_id');
    }

    public function operations(): HasMany
    {
        return $this->hasMany(SfdOperation::class, 'bom_id');
    }

    public function manufacturingOrders(): HasMany
    {
        return $this->hasMany(SfdManufacturingOrder::class, 'bom_id');
    }
}

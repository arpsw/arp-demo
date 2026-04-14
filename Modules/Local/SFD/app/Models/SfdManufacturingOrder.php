<?php

namespace Modules\SFD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\SFD\Database\Factories\SfdManufacturingOrderFactory;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;

class SfdManufacturingOrder extends Model
{
    use HasFactory;

    protected $table = 'sfd_manufacturing_orders';

    protected $fillable = [
        'reference',
        'product_id',
        'bom_id',
        'quantity',
        'status',
        'priority',
        'scheduled_date',
        'deadline',
        'completed_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'status' => ManufacturingOrderStatus::class,
            'priority' => ManufacturingOrderPriority::class,
            'scheduled_date' => 'date',
            'deadline' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    protected static function newFactory(): SfdManufacturingOrderFactory
    {
        return SfdManufacturingOrderFactory::new();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(SfdProduct::class, 'product_id');
    }

    public function billOfMaterial(): BelongsTo
    {
        return $this->belongsTo(SfdBillOfMaterial::class, 'bom_id');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(SfdWorkOrder::class, 'manufacturing_order_id');
    }
}

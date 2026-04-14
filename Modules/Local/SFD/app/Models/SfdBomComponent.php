<?php

namespace Modules\SFD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SFD\Database\Factories\SfdBomComponentFactory;

class SfdBomComponent extends Model
{
    use HasFactory;

    protected $table = 'sfd_bom_components';

    protected $fillable = [
        'bom_id',
        'product_id',
        'quantity',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
        ];
    }

    protected static function newFactory(): SfdBomComponentFactory
    {
        return SfdBomComponentFactory::new();
    }

    public function billOfMaterial(): BelongsTo
    {
        return $this->belongsTo(SfdBillOfMaterial::class, 'bom_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(SfdProduct::class, 'product_id');
    }
}

<?php

namespace Modules\SFD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SFD\Database\Factories\SfdOperationFactory;

class SfdOperation extends Model
{
    use HasFactory;

    protected $table = 'sfd_operations';

    protected $fillable = [
        'bom_id',
        'work_center_id',
        'name',
        'duration_minutes',
        'description',
        'sort_order',
    ];

    protected static function newFactory(): SfdOperationFactory
    {
        return SfdOperationFactory::new();
    }

    public function billOfMaterial(): BelongsTo
    {
        return $this->belongsTo(SfdBillOfMaterial::class, 'bom_id');
    }

    public function workCenter(): BelongsTo
    {
        return $this->belongsTo(SfdWorkCenter::class, 'work_center_id');
    }
}

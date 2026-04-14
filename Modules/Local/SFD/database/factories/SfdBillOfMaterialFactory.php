<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Models\SfdProduct;

class SfdBillOfMaterialFactory extends Factory
{
    protected $model = SfdBillOfMaterial::class;

    public function definition(): array
    {
        return [
            'product_id' => SfdProduct::factory(),
            'name' => fake()->words(3, true),
            'quantity' => 1,
            'is_active' => true,
        ];
    }
}

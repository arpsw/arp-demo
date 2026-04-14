<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Models\SfdBomComponent;
use Modules\SFD\Models\SfdProduct;

class SfdBomComponentFactory extends Factory
{
    protected $model = SfdBomComponent::class;

    public function definition(): array
    {
        return [
            'bom_id' => SfdBillOfMaterial::factory(),
            'product_id' => SfdProduct::factory(),
            'quantity' => fake()->randomFloat(3, 0.1, 10),
            'sort_order' => 0,
        ];
    }
}

<?php

namespace Modules\SFD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Enums\QualityCheckResult;
use Modules\SFD\Enums\QualityCheckType;
use Modules\SFD\Models\SfdQualityCheck;
use Modules\SFD\Models\SfdWorkOrder;

class SfdQualityCheckFactory extends Factory
{
    protected $model = SfdQualityCheck::class;

    public function definition(): array
    {
        return [
            'work_order_id' => SfdWorkOrder::factory(),
            'name' => fake()->words(3, true),
            'type' => QualityCheckType::PassFail,
            'result' => QualityCheckResult::Pending,
            'measured_value' => null,
            'notes' => null,
            'checked_by' => null,
            'checked_at' => null,
            'sort_order' => 0,
        ];
    }

    public function passed(): static
    {
        return $this->state(fn () => [
            'result' => QualityCheckResult::Pass,
            'checked_at' => now(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn () => [
            'result' => QualityCheckResult::Fail,
            'checked_at' => now(),
        ]);
    }
}

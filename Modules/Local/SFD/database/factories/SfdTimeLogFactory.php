<?php

namespace Modules\SFD\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SFD\Models\SfdTimeLog;
use Modules\SFD\Models\SfdWorkOrder;

class SfdTimeLogFactory extends Factory
{
    protected $model = SfdTimeLog::class;

    public function definition(): array
    {
        $startedAt = fake()->dateTimeBetween('-1 week', 'now');
        $durationMinutes = fake()->numberBetween(15, 180);

        return [
            'work_order_id' => SfdWorkOrder::factory(),
            'user_id' => User::factory(),
            'started_at' => $startedAt,
            'ended_at' => (clone $startedAt)->modify("+{$durationMinutes} minutes"),
            'duration_minutes' => $durationMinutes,
        ];
    }
}

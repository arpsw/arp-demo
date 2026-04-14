<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\MNT\Database\Seeders\MNTSeeder;
use Modules\SFD\Database\Seeders\SFDSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            AgentSeeder::class,
            AISeeder::class,
            SFDSeeder::class,
            MNTSeeder::class,
        ]);
    }
}

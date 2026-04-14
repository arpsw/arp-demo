<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('shield:generate', ['--all' => true, '--panel' => 'core', '--no-interaction' => true]);
        Artisan::call('shield:generate', ['--all' => true, '--panel' => 'ai', '--no-interaction' => true]);
        Artisan::call('shield:generate', ['--all' => true, '--panel' => 'mnt', '--no-interaction' => true]);
        Artisan::call('shield:generate', ['--all' => true, '--panel' => 'sfd', '--no-interaction' => true]);

        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole($role);
    }
}

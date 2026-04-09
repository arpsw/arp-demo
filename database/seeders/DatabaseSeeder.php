<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create super_admin role if it doesn't exist
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            ['guard_name' => 'web']
        );

        // Create panel_user role if it doesn't exist
        Role::firstOrCreate(
            ['name' => 'arp_user'],
            ['guard_name' => 'web']
        );

        // Generate Shield permissions for all panels
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--no-interaction' => true,
        ]);
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'ai',
            '--no-interaction' => true,
        ]);

        // Create admin user with super_admin role
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin'),
            ]
        );
        $admin->assignRole($superAdminRole);

        // Create test user with panel_user role
        $testUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => bcrypt('user'),
            ]
        );
        $testUser->assignRole('arp_user');
    }
}

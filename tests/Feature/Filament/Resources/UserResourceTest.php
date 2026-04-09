<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        $permissions = [
            'ViewAny:User',
            'View:User',
            'Create:User',
            'Update:User',
            'Delete:User',
            'DeleteAny:User',
            'Restore:User',
            'ForceDelete:User',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdminRole->syncPermissions($permissions);

        $this->admin = User::factory()->create();
        $this->admin->assignRole($superAdminRole);
    }

    public function test_can_render_list_users_page(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ListUsers::class)
            ->assertSuccessful();
    }

    public function test_can_list_users(): void
    {
        $users = User::factory()->count(3)->create();

        Livewire::actingAs($this->admin)
            ->test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }

    public function test_can_search_users_by_name(): void
    {
        $user = User::factory()->create(['name' => 'Unique Test Name']);
        User::factory()->count(3)->create();

        Livewire::actingAs($this->admin)
            ->test(ListUsers::class)
            ->searchTable('Unique Test Name')
            ->assertCanSeeTableRecords([$user]);
    }

    public function test_can_search_users_by_email(): void
    {
        $user = User::factory()->create(['email' => 'unique@example.com']);
        User::factory()->count(3)->create();

        Livewire::actingAs($this->admin)
            ->test(ListUsers::class)
            ->searchTable('unique@example.com')
            ->assertCanSeeTableRecords([$user]);
    }

    public function test_can_render_create_user_page(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateUser::class)
            ->assertSuccessful();
    }

    public function test_can_create_user(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'New Test User',
                'email' => 'newuser@example.com',
                'password' => 'password123',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'New Test User',
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_can_create_user_with_roles(): void
    {
        $role = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => 'password123',
                'roles' => [$role->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'editor@example.com')->first();
        $this->assertTrue($user->hasRole('editor'));
    }

    public function test_create_user_validates_required_fields(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => '',
                'email' => '',
                'password' => '',
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);
    }

    public function test_create_user_validates_unique_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        Livewire::actingAs($this->admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'New User',
                'email' => 'existing@example.com',
                'password' => 'password123',
            ])
            ->call('create')
            ->assertHasFormErrors(['email' => 'unique']);
    }

    public function test_can_render_view_user_page(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(ViewUser::class, ['record' => $user->id])
            ->assertSuccessful();
    }

    public function test_can_render_edit_user_page(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $user->id])
            ->assertSuccessful();
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $user->id])
            ->fillForm([
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_can_update_user_without_changing_password(): void
    {
        $user = User::factory()->create();
        $originalPasswordHash = $user->password;

        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $user->id])
            ->fillForm([
                'name' => 'Updated Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertEquals($originalPasswordHash, $user->password);
    }

    public function test_can_update_user_roles(): void
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $user->id])
            ->fillForm([
                'roles' => [$role->id],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertTrue($user->hasRole('moderator'));
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $user->id])
            ->callAction('delete')
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

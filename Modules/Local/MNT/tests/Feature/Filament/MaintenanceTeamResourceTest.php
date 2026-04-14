<?php

namespace Modules\MNT\Tests\Feature\Filament;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Modules\MNT\Enums\TeamMemberRole;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Pages\CreateMaintenanceTeam;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Pages\EditMaintenanceTeam;
use Modules\MNT\Filament\Resources\MaintenanceTeams\Pages\ListMaintenanceTeams;
use Modules\MNT\Models\MntMaintenanceTeam;
use Tests\TestCase;

class MaintenanceTeamResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel(Filament::getPanel('mnt'));
        Gate::before(fn () => true);

        $this->admin = User::factory()->create();
    }

    public function test_list_page_renders(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ListMaintenanceTeams::class)
            ->assertSuccessful();
    }

    public function test_create_page_renders(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->assertSuccessful();
    }

    public function test_can_create_team_with_members(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->fillForm([
                'name' => 'Test Team',
                'color' => '#ff0000',
                'members' => [
                    [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'phone' => '+38631614683',
                        'role' => TeamMemberRole::Leader->value,
                    ],
                    [
                        'first_name' => 'Jane',
                        'last_name' => 'Smith',
                        'phone' => '+38641234567',
                        'role' => TeamMemberRole::Member->value,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('mnt_maintenance_teams', [
            'name' => 'Test Team',
        ]);

        $team = MntMaintenanceTeam::where('name', 'Test Team')->first();
        $this->assertCount(2, $team->members);
        $this->assertEquals('John', $team->members->first()->first_name);
        $this->assertEquals('+38631614683', $team->members->first()->phone);
    }

    public function test_edit_page_renders(): void
    {
        $team = MntMaintenanceTeam::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(EditMaintenanceTeam::class, ['record' => $team->id])
            ->assertSuccessful();
    }

    public function test_phone_validation_rejects_invalid_format(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->fillForm([
                'name' => 'Test Team',
                'members' => [
                    [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'phone' => '031614683',
                        'role' => TeamMemberRole::Member->value,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors(['members.0.phone']);
    }

    public function test_phone_validation_accepts_valid_format(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->fillForm([
                'name' => 'Valid Phone Team',
                'members' => [
                    [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'phone' => '+38631614683',
                        'role' => TeamMemberRole::Member->value,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('mnt_maintenance_team_members', [
            'phone' => '+38631614683',
        ]);
    }

    public function test_member_first_name_is_required(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->fillForm([
                'name' => 'Test Team',
                'members' => [
                    [
                        'first_name' => null,
                        'last_name' => 'Doe',
                        'role' => TeamMemberRole::Member->value,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors(['members.0.first_name' => 'required']);
    }

    public function test_member_last_name_is_required(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->fillForm([
                'name' => 'Test Team',
                'members' => [
                    [
                        'first_name' => 'John',
                        'last_name' => null,
                        'role' => TeamMemberRole::Member->value,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors(['members.0.last_name' => 'required']);
    }

    public function test_phone_is_optional(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateMaintenanceTeam::class)
            ->fillForm([
                'name' => 'No Phone Team',
                'members' => [
                    [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'phone' => null,
                        'role' => TeamMemberRole::Member->value,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('mnt_maintenance_team_members', [
            'first_name' => 'John',
            'phone' => null,
        ]);
    }
}

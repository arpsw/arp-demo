<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\MNT\Enums\TeamMemberRole;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mnt_maintenance_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('mnt_maintenance_teams')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('role')->default(TeamMemberRole::Member->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mnt_maintenance_team_members');
    }
};

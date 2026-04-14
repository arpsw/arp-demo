<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\MNT\Enums\MaintenancePriority;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mnt_preventive_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('mnt_equipment')->cascadeOnDelete();
            $table->string('name');
            $table->integer('frequency_days');
            $table->foreignId('team_id')->nullable()->constrained('mnt_maintenance_teams')->nullOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('priority')->default(MaintenancePriority::Normal->value);
            $table->text('description')->nullable();
            $table->date('last_generated_date')->nullable();
            $table->date('next_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mnt_preventive_schedules');
    }
};

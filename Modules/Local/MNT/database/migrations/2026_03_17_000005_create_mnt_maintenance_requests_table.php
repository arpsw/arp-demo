<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mnt_maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('name');
            $table->foreignId('equipment_id')->nullable()->constrained('mnt_equipment')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('mnt_equipment_categories')->nullOnDelete();
            $table->string('request_type')->default(MaintenanceRequestType::Corrective->value);
            $table->string('priority')->default(MaintenancePriority::Normal->value);
            $table->string('stage')->default(MaintenanceStage::New->value);
            $table->foreignId('team_id')->nullable()->constrained('mnt_maintenance_teams')->nullOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('scheduled_date')->nullable();
            $table->date('close_date')->nullable();
            $table->decimal('duration', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mnt_maintenance_requests');
    }
};

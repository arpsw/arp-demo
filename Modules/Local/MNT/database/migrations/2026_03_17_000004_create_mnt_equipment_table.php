<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\MNT\Enums\EquipmentStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mnt_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial_number')->nullable()->unique();
            $table->foreignId('category_id')->nullable()->constrained('mnt_equipment_categories')->nullOnDelete();
            $table->foreignId('work_center_id')->nullable()->constrained('sfd_work_centers')->nullOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('location')->nullable();
            $table->string('model')->nullable();
            $table->string('manufacturer')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->date('effective_date')->nullable();
            $table->string('status')->default(EquipmentStatus::Operational->value);
            $table->integer('mtbf')->nullable();
            $table->integer('mttr')->nullable();
            $table->integer('expected_mtbf')->nullable();
            $table->date('latest_failure_date')->nullable();
            $table->date('next_preventive_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mnt_equipment');
    }
};

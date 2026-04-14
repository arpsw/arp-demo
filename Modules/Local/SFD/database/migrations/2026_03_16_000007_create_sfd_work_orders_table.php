<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SFD\Enums\WorkOrderStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturing_order_id')->constrained('sfd_manufacturing_orders')->cascadeOnDelete();
            $table->foreignId('operation_id')->constrained('sfd_operations');
            $table->foreignId('work_center_id')->constrained('sfd_work_centers');
            $table->string('name');
            $table->string('status')->default(WorkOrderStatus::Pending->value);
            $table->integer('expected_duration');
            $table->integer('actual_duration')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_work_orders');
    }
};

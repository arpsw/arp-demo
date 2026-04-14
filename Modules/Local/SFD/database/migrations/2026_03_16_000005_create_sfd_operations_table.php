<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('sfd_bill_of_materials')->cascadeOnDelete();
            $table->foreignId('work_center_id')->constrained('sfd_work_centers');
            $table->string('name');
            $table->integer('duration_minutes');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_operations');
    }
};

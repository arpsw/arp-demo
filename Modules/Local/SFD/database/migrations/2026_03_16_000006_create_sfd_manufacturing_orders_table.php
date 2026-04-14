<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_manufacturing_orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('product_id')->constrained('sfd_products');
            $table->foreignId('bom_id')->constrained('sfd_bill_of_materials');
            $table->decimal('quantity', 10, 2);
            $table->string('status')->default(ManufacturingOrderStatus::Draft->value);
            $table->string('priority')->default(ManufacturingOrderPriority::Normal->value);
            $table->date('scheduled_date')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_manufacturing_orders');
    }
};

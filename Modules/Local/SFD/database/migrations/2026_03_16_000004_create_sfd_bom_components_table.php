<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_bom_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('sfd_bill_of_materials')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('sfd_products');
            $table->decimal('quantity', 10, 3);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_bom_components');
    }
};

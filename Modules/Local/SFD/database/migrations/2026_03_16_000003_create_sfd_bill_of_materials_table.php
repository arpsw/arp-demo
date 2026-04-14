<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_bill_of_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('sfd_products')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_bill_of_materials');
    }
};

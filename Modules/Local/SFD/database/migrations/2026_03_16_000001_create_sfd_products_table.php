<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SFD\Enums\ProductType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('type')->default(ProductType::RawMaterial->value);
            $table->text('description')->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_products');
    }
};

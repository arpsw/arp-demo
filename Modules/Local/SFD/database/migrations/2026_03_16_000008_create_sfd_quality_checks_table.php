<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SFD\Enums\QualityCheckResult;
use Modules\SFD\Enums\QualityCheckType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sfd_quality_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('sfd_work_orders')->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default(QualityCheckType::PassFail->value);
            $table->string('result')->default(QualityCheckResult::Pending->value);
            $table->string('measured_value')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('checked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('checked_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sfd_quality_checks');
    }
};

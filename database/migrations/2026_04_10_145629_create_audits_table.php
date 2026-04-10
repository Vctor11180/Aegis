<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('token_symbol');
            $table->string('token_name')->nullable();
            $table->integer('risk_score')->default(0);
            $table->string('threat_level')->default('MEDIO');
            $table->text('reasoning')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('tx_hash')->nullable();
            $table->decimal('amount_xlm', 20, 7)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};

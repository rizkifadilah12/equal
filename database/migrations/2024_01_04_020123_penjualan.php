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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('date');
            $table->integer('qty');
            $table->float('cost');
            $table->integer('price');
            $table->decimal('total_cost')->default(0);
            $table->integer('qty_balance');
            $table->float('value_balance');
            $table->float('hpp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};

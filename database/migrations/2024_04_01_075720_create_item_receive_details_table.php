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
        Schema::create('item_receive_details', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');

            $table->foreignId('purchase_detail_id')->constrained();
            $table->foreignId('item_receive_id')->constrained();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_receive_details');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("ticket_name");
            $table->string("ticket_price");
            $table->string("lot_number");
            $table->string("prize_amount");
            $table->string("winner_count");
            $table->string("max_purchase_limit");
            $table->string("color");
            $table->string("purchase_count");
            $table->string("algo_winner");
            $table->string("manual_winner");
            $table->boolean("is_visible");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

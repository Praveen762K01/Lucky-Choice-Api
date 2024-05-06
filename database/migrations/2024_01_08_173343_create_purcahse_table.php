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
        Schema::create('purcahse', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->string("lot_number");
            $table->string("ticket_id");
            $table->string("serial_no");
            $table->boolean("is_paid");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purcahse');
    }
};

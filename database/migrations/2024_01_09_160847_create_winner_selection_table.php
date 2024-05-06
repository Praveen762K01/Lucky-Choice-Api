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
        Schema::create('winner_selection', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->string("ticket_id");
            $table->string("purchase_id");
            $table->boolean("winner");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winner_selection');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username');
            $table->text('history');
            $table->integer('wins');
            $table->integer('loses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_history');
    }
};

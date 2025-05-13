<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('game_users', function (Blueprint $table) {
          $table->id();
          $table->timestamps();
          $table->string('username');
          $table->string('password');
          $table->string('email')->unique();
          $table->string('master_icon_path')->nullable();
          $table->string('first_name');
          $table->string('last_name');
          $table->string('country')->nullable();
          $table->string('city')->nullable();
          $table->date('birthdate_date_format')->nullable();
          $table->string('birthdate_string_format')->nullable();
          $table->string('gender')->nullable();
          $table->text('user_bio')->nullable();
          $table->text('cards')->nullable();
          $table->text('deck')->nullable();
          $table->integer('wins')->nullable();
          $table->integer('loses')->nullable();
          $table->integer('points')->nullable();
          $table->string('game_history')->nullable();
          //If the name of the column matches another table, Laravel connects them automatically
          $table->foreignId('game_history_id')->constrained('game_history');
      });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_users');
    }
};

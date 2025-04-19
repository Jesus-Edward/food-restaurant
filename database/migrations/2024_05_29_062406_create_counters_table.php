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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->text('background');
            $table->string('counter_title_one');
            $table->string('counter_count_one');
            $table->string('counter_icon_one');

            $table->string('counter_title_two');
            $table->string('counter_count_two');
            $table->string('counter_icon_two');

            $table->string('counter_title_three');
            $table->string('counter_count_three');
            $table->string('counter_icon_three');

            $table->string('counter_title_four');
            $table->string('counter_count_four');
            $table->string('counter_icon_four');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};

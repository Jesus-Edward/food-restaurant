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
        Schema::create('chef_teams', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->string('name');
            $table->string('title');
            $table->string('fb')->nullable();
            $table->string('in')->nullable();
            $table->string('x_link')->nullable();
            $table->string('web')->nullable();
            $table->boolean('show_at_home')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chef_teams');
    }
};

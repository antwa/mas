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
        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->uuid("pub_id")->default(\Illuminate\Support\Str::uuid());;
            $table->string("key", 200);
            $table->string('name', 100)->nullable();
            $table->string('value', 255)->nullable();
            $table->text('file')->nullable();
            $table->enum('type', ['system', 'default', 'user'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};

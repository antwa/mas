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
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->uuid("pub_id");
            $table->string("nama",250);
            $table->text("alamat");
            $table->string("kepala");
            $table->string("no_kepala");
            $table->string("website");
            $table->string("email");
            $table->string("telpon",20);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign("created_by")->references('id')->on("users");
            $table->foreign("updated_by")->references('id')->on("users");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};

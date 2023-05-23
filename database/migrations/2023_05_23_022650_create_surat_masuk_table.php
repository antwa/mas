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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->uuid("pub_id")->default(\Illuminate\Support\Str::uuid());
            $table->string("no_surat",50)->unique();
            $table->string("dari",100);
            $table->text("isi_singkat")->nullable();
            $table->string("prihal",100);
            $table->date("tgl_surat");
            $table->date("tgl_arsip");
            $table->text("keterangan")->nullable();
            $table->enum('status_disposisi', ['y', 't'])->default('t');
            $table->text("file")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};

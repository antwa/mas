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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->uuid("pub_id")->default(\Illuminate\Support\Str::uuid());
            $table->string("no_surat",50);
            $table->string("dari",100);
            $table->string("tujuan",100);
            $table->mediumText("isi_singkat")->nullable();
            $table->string("jenis",100)->nullable();
            $table->string("prihal",100);
            $table->date("tgl_surat");
            $table->date("tgl_arsip");
            $table->text("keterangan")->nullable();
            $table->text("file")->nullable();
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
        Schema::dropIfExists('surat_keluar');
    }
};

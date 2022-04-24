<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id('idPegawai');
            $table->string('namaPgw');
            $table->string('alamatPgw');
            $table->date('tglLahirPgw');
            $table->string('jenisKelaminPgw');
            $table->string('emailPgw')->unique();
            $table->string('noTelpPgw');
            $table->longtext('urlFotoPgw','4294967295');
            $table->unsignedInteger('jumlahShiftPgw');
            $table->unsignedBigInteger('idRole');
            $table->foreign('idRole')->references('idRole')->on('roles');
            $table->string('passwordPgw');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};

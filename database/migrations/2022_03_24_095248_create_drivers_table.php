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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('idDriver');
            $table->string('idDriverGenerated');
            $table->string('namaDrv');
            $table->string('alamatDrv');
            $table->date('tglLahirDrv');
            $table->string('jenisKelaminDrv');
            $table->string('emailDrv')->unique();
            $table->string('noTelpDrv');
            $table->unsignedInteger('bahasaAsing');
            $table->longtext('urlFotoDrv','4294967295');
            $table->unsignedInteger('statusDrv');
            $table->longtext('simDrv','4294967295');
            $table->float('tarifDrv');
            $table->longtext('suratBebasNapzaDrv','4294967295');
            $table->longtext('suratKesehatanJiwaDrv','4294967295');
            $table->longtext('suratKesehatanJasmaniDrv','4294967295');
            $table->longtext('skckDrv','4294967295');
            $table->float('rerataRatingDrv');
            $table->string('passwordDrv');
            $table->unsignedInteger('statusDokumenDrv');
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
        Schema::dropIfExists('drivers');
    }
};

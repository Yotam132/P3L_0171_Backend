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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id('idMobil');
            $table->unsignedBigInteger('idMitra')->nullable();
            $table->foreign('idMitra')->references('idMitra')->on('mitras');
            $table->string('namaMbl');
            $table->longtext('urlFotoMbl','4294967295');
            $table->string('tipeMbl');
            $table->string('jenisTransmisi');
            $table->string('jenisBahanBakar');
            $table->string('warna');
            $table->float('volumeBahanBakar');
            $table->integer('kapasitasPenumpang');
            $table->string('fasilitas');
            $table->string('platNomor');
            $table->string('noStnk');
            $table->float('hargaSewa');
            $table->string('kategoriAset');
            $table->date('periodeKontrakMulai');
            $table->date('periodeKontrakAkhir');
            $table->date('tglServisTerakhir');
            $table->unsignedInteger('statusMbl');
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
        Schema::dropIfExists('mobils');
    }
};

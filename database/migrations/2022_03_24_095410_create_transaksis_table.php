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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->unsignedBigInteger('idMobil');
            $table->foreign('idMobil')->references('idMobil')->on('mobils');
            $table->unsignedBigInteger('idDriver')->nullable();
            $table->foreign('idDriver')->references('idDriver')->on('drivers');
            $table->unsignedBigInteger('idCustomer');
            $table->foreign('idCustomer')->references('idCustomer')->on('customers');
            $table->date('tglSewaAwal');
            $table->date('tglSewaAkhir');
            $table->string('metodePembayaran');
            $table->float('subTotal', 15, 4);
            $table->unsignedBigInteger('idPegawai');
            $table->foreign('idPegawai')->references('idPegawai')->on('pegawais');
            $table->unsignedBigInteger('idPromo')->nullable();
            $table->foreign('idPromo')->references('idPromo')->on('promos');
            $table->string('idTransaksiGenerated');
            $table->date('tglPengembalian');
            $table->string('statusTransaksi');
            $table->float('totalHargaAkhir', 15, 4);
            $table->float('ratingDriver');
            $table->float('ratingPerusahaan');

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
        Schema::dropIfExists('transaksis');
    }
};

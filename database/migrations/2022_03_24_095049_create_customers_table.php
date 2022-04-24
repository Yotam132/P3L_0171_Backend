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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('idCustomer');
            $table->string('idCustomerGenerated');
            $table->string('namaCust');
            $table->string('alamatCust');
            $table->date('tglLahirCust');
            $table->string('jenisKelaminCust');
            $table->string('emailCust')->unique();;
            $table->string('noTelpCust');
            $table->longtext('kartuPengenalCust','4294967295');
            $table->longtext('simCust','4294967295');
            $table->string('passwordCust');
            $table->unsignedInteger('statusDokumenCust');

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
        Schema::dropIfExists('customers');
    }
};

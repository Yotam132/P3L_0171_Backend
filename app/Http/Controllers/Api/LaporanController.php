<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;

class LaporanController extends Controller
{
    public function laporanPenyewaanMobil($date)
    {
        $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $laporans = DB::select("SELECT M.tipeMbl, M.namaMbl, COUNT(T.idMobil) AS 'Jumlah Peminjaman', SUM(M.hargaSewa * (T.tglSewaAkhir+1 - T.tglSewaAwal)) AS 'Total Pendapatan' FROM mobils M JOIN transaksis T ON (M.idMobil = T.idMobil) WHERE T.tglSewaAwal BETWEEN '$start' and '$end' GROUP BY M.idMobil ORDER BY `Total Pendapatan` DESC");



        if(count($laporans) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $laporans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function laporanDetailPendapatan($date)
    {
        $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $laporans = DB::select("SELECT C.namaCust, M.namaMbl,
        (CASE
            WHEN T.idDriver > 0 THEN 'Peminjaman Mobil + Driver' 
            ELSE 'Peminjaman Mobil'
        END) AS 'Jenis Transaksi',
        count(T.idCustomer) AS 'Jumlah Transaksi', SUM(T.totalHargaAkhir) AS 'Pendapatan' FROM transaksis T JOIN customers C ON (T.idCustomer = C.idCustomer) JOIN mobils M ON (M.idMobil = T.idMobil) WHERE T.tglSewaAwal BETWEEN '$start' AND '$end'
        GROUP BY T.idCustomer, `Jenis Transaksi`");



        if(count($laporans) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $laporans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function laporanDriverTransaksiTerbanyak($date)
    {
        $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $laporans = DB::select("SELECT D.idDriverGenerated, D.namaDrv, count(T.idDriver) AS 'Jumlah Transaksi' FROM transaksis T JOIN drivers D ON (T.idDriver = D.idDriver) WHERE T.tglSewaAwal BETWEEN '$start' AND '$end' GROUP BY T.idDriver ORDER BY `Jumlah Transaksi` DESC LIMIT 5");



        if(count($laporans) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $laporans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function laporanPerformaDriver($date)
    {
        $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $laporans = DB::select("SELECT D.idDriverGenerated, D.namaDrv, count(T.idDriver) AS 'Jumlah Transaksi', AVG(T.ratingDriver) AS 'Rerata Rating' FROM transaksis T JOIN drivers D ON (T.idDriver = D.idDriver) WHERE T.tglSewaAwal BETWEEN '$start' AND '$end' GROUP BY T.idDriver ORDER BY `Jumlah Transaksi` DESC LIMIT 5");



        if(count($laporans) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $laporans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function laporanTransaksiCustomerTerbanyak($date)
    {
        $start = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $end = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $laporans = DB::select("SELECT C.namaCust, count(T.idCustomer) AS 'Jumlah Transaksi' FROM transaksis T JOIN customers C ON (T.idCustomer = C.idCustomer) WHERE T.tglSewaAwal BETWEEN '$start' AND '$end' GROUP BY T.idCustomer ORDER BY `Jumlah Transaksi` DESC LIMIT 5");


        if(count($laporans) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $laporans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => $laporans
        ], 400);
    }
}

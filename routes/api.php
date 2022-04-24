<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$route = 'App\\Http\\Controllers\\';


Route::post('login', $route . 'Api\LoginController@login');
Route::get('detailjdw', $route . 'Api\DetailJadwalController@showAllData');


Route::get('detailjdw', $route . 'Api\DetailJadwalController@showAllData');
Route::get('detailjdw/{id}', $route . 'Api\DetailJadwalController@showById');
Route::post('detailjdw', $route . 'Api\DetailJadwalController@store');
Route::delete('detailjdw/{id}', $route . 'Api\DetailJadwalController@destroy');
Route::put('detailjdw/{id}', $route . 'Api\DetailJadwalController@update');

Route::get('jadwal', $route . 'Api\JadwalController@showAllData');
Route::get('jadwal/{id}', $route . 'Api\JadwalController@showById');
Route::post('jadwal', $route . 'Api\JadwalController@store');
Route::delete('jadwal/{id}', $route . 'Api\JadwalController@destroy');
Route::put('jadwal/{id}', $route . 'Api\JadwalController@update');

Route::get('mitra', $route . 'Api\MitraController@showAllData');
Route::get('mitra/{id}', $route . 'Api\MitraController@showById');
Route::post('mitra', $route . 'Api\MitraController@store');
Route::delete('mitra/{id}', $route . 'Api\MitraController@destroy');
Route::put('mitra/{id}', $route . 'Api\MitraController@update');

Route::get('role', $route . 'Api\RoleController@showAllData');
Route::get('role/{id}', $route . 'Api\RoleController@showById');
Route::post('role', $route . 'Api\RoleController@store');
Route::delete('role/{id}', $route . 'Api\RoleController@destroy');
Route::put('role/{id}', $route . 'Api\RoleController@update');



// With Custom Function
Route::get('transaksi', $route . 'Api\TransaksiController@showAllData');
Route::get('transaksicust/{id}', $route . 'Api\TransaksiController@showAllDataOfCust');
Route::get('transaksidrv/{id}', $route . 'Api\TransaksiController@showAllDataOfDrv');
Route::get('transaksipgw/{id}', $route . 'Api\TransaksiController@showAllDataOfPgw');
Route::get('transaksi/{id}', $route . 'Api\TransaksiController@showById');
Route::post('transaksi', $route . 'Api\TransaksiController@store');
Route::delete('transaksi/{id}', $route . 'Api\TransaksiController@destroy');
Route::put('transaksi/{id}', $route . 'Api\TransaksiController@update');
Route::put('transaksistat/{id}', $route . 'Api\TransaksiController@updateStatus');

Route::get('customer', $route . 'Api\CustomerController@showAllData');
Route::get('customer/{id}', $route . 'Api\CustomerController@showById');
Route::post('customer', $route . 'Api\CustomerController@store');
// Route::delete('customer/{id}', $route . 'Api\CustomerController@destroy');
Route::put('customer/{id}', $route . 'Api\CustomerController@update');
Route::get('customerstatdokumen/{id}', $route . 'Api\CustomerController@ToggleSwitchStatusDokumenCustomer');

Route::get('driver', $route . 'Api\DriverController@showAllData');
Route::get('driver/{id}', $route . 'Api\DriverController@showById');
Route::get('driveravailable/{stat}', $route . 'Api\DriverController@showAvailableDrivers');
Route::post('driver', $route . 'Api\DriverController@store');
Route::delete('driver/{id}', $route . 'Api\DriverController@destroy');
Route::put('driver/{id}', $route . 'Api\DriverController@update');
Route::put('driverrating/{id}', $route . 'Api\DriverController@updateRating');
Route::get('driverstat/{id}', $route . 'Api\DriverController@ToggleSwitchStatusDriver');
Route::get('driverstatdokumen/{id}', $route . 'Api\DriverController@ToggleSwitchStatusDokumenDriver');

Route::get('mobil', $route . 'Api\MobilController@showAllData');
Route::get('mobil/{id}', $route . 'Api\MobilController@showById');
Route::get('mobilavailable/{stat}', $route . 'Api\MobilController@showAvailableMobils');
Route::post('mobil', $route . 'Api\MobilController@store');
Route::delete('mobil/{id}', $route . 'Api\MobilController@destroy');
Route::put('mobil/{id}', $route . 'Api\MobilController@update');
Route::get('mobilstat/{id}', $route . 'Api\MobilController@ToggleSwitchStatusMobil');

Route::get('pegawai', $route . 'Api\PegawaiController@showAllData');
Route::get('pegawai/{id}', $route . 'Api\PegawaiController@showById');
Route::get('pegawaics', $route . 'Api\PegawaiController@GetCustomerService');
Route::post('pegawai', $route . 'Api\PegawaiController@store');
Route::delete('pegawai/{id}', $route . 'Api\PegawaiController@destroy');
Route::put('pegawai/{id}', $route . 'Api\PegawaiController@update');
Route::get('pegawai/{id}/{value}', $route . 'Api\PegawaiController@incrementOrDecrementJumlahShift');

Route::get('promo', $route . 'Api\PromoController@showAllData');
Route::get('promo/{id}', $route . 'Api\PromoController@showById');
Route::get('promoactive/{stat}', $route . 'Api\PromoController@showActivePromos');
Route::post('promo', $route . 'Api\PromoController@store');
Route::delete('promo/{id}', $route . 'Api\PromoController@destroy');
Route::put('promo/{id}', $route . 'Api\PromoController@update');
Route::get('promostat/{id}', $route . 'Api\PromoController@ToggleSwitchStatusPromo');

Route::get('laporansewamobil/{date}', $route . 'Api\LaporanController@laporanPenyewaanMobil');
Route::get('laporandetailpendapatan/{date}', $route . 'Api\LaporanController@laporanDetailPendapatan');
Route::get('laporandrivertransaksiterbanyak/{date}', $route . 'Api\LaporanController@laporanDriverTransaksiTerbanyak');
Route::get('laporanperformadriver/{date}', $route . 'Api\LaporanController@laporanPerformaDriver');
Route::get('laporantransaksicustomerterbanyak/{date}', $route . 'Api\LaporanController@laporanTransaksiCustomerTerbanyak');

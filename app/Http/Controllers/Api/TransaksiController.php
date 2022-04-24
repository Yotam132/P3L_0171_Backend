<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function showAllData()
    {
        $transaksis = Transaksi::all();

        if(count($transaksis) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $transaksis
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showAllDataOfCust($id)
    {
        $transaksis = Transaksi::where('idCustomer', $id)->get();

        if(count($transaksis) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $transaksis
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showAllDataOfDrv($id)
    {
        $transaksis = Transaksi::where('idDriver', $id)->get();

        if(count($transaksis) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $transaksis
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showAllDataOfPgw($id)
    {
        $transaksis = Transaksi::where('idPegawai', $id)->get();

        if(count($transaksis) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $transaksis
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $transaksi = Transaksi::find($id);

        if(!is_null($transaksi))
        {
            return response([
                'message' => 'Success',
                'data'    => $transaksi
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data'    => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'idMobil' => 'required|numeric',
            'idCustomer' => 'required|numeric',
            'tglSewaAwal' => 'required',
            'tglSewaAkhir' => 'required',
            'metodePembayaran' => 'required',
            'subTotal' => 'required|numeric',
            
            'idPegawai' => 'required|numeric',
            'tglPengembalian' => 'required',
            'totalHargaAkhir' => 'required|numeric',

        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $prefix = "TRN" . date('ymd');
        $temp = Transaksi::select('idTransaksi')->orderBy('idTransaksi','desc')->first();

        if(is_null($storeData['idDriver']))
        {
            $midfix = "00-";
        }
        else
        {
            $midfix = "01-";
        }

        $id = $prefix . $midfix . $temp->getID($temp['idTransaksi']);
        $storeData['idTransaksiGenerated'] = $id;

        $storeData['ratingDriver'] = 0;
        $storeData['ratingPerusahaan'] = 0;
        $storeData['statusTransaksi'] = "Belum Verifikasi";
        $Transaksi = Transaksi::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $Transaksi
        ], 200);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        if(is_null($transaksi))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($transaksi->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $transaksi
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if(is_null($transaksi))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'idMobil' => 'required|numeric',
            'tglSewaAwal' => 'required',
            'tglSewaAkhir' => 'required',
            'metodePembayaran' => 'required',
            'subTotal' => 'required|numeric',
            
            'idPegawai' => 'required|numeric',
            'tglPengembalian' => 'required',
            'totalHargaAkhir' => 'required|numeric',
            'ratingDriver' => 'required|numeric|between:0,10',
            'ratingPerusahaan' => 'required|numeric|between:0,10',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $transaksi->idCustomer = $transaksi['idCustomer'];
        $transaksi->statusTransaksi = $transaksi['statusTransaksi'];
        $transaksi->idTransaksiGenerated = $transaksi['idTransaksiGenerated'];

        
        $transaksi->idPegawai = $updateData['idPegawai'];
        $transaksi->idDriver = $updateData['idDriver'];
        $transaksi->idPromo = $updateData['idPromo'];
        $transaksi->idMobil = $updateData['idMobil'];
        $transaksi->tglSewaAwal = $updateData['tglSewaAwal'];
        $transaksi->tglSewaAkhir = $updateData['tglSewaAkhir'];
        $transaksi->metodePembayaran = $updateData['metodePembayaran'];
        $transaksi->subTotal = $updateData['subTotal'];
        $transaksi->tglPengembalian = $updateData['tglPengembalian'];
        $transaksi->totalHargaAkhir = $updateData['totalHargaAkhir'];
        $transaksi->ratingDriver = $updateData['ratingDriver'];
        $transaksi->ratingPerusahaan = $updateData['ratingPerusahaan'];

        if($transaksi->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $transaksi
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if(is_null($transaksi))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'statusTransaksi' => 'required',
            'totalHargaAkhir' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $transaksi->statusTransaksi = $updateData['statusTransaksi'];
        $transaksi->totalHargaAkhir = $updateData['totalHargaAkhir'];

        $transaksi->idCustomer = $transaksi['idCustomer'];
        $transaksi->idTransaksiGenerated = $transaksi['idTransaksiGenerated'];        
        $transaksi->idPegawai = $transaksi['idPegawai'];
        $transaksi->idDriver = $transaksi['idDriver'];
        $transaksi->idPromo = $transaksi['idPromo'];
        $transaksi->idMobil = $transaksi['idMobil'];
        $transaksi->tglSewaAwal = $transaksi['tglSewaAwal'];
        $transaksi->tglSewaAkhir = $transaksi['tglSewaAkhir'];
        $transaksi->metodePembayaran = $transaksi['metodePembayaran'];
        $transaksi->subTotal = $transaksi['subTotal'];
        $transaksi->tglPengembalian = $transaksi['tglPengembalian'];
        $transaksi->ratingDriver = $transaksi['ratingDriver'];
        $transaksi->ratingPerusahaan = $transaksi['ratingPerusahaan'];

        if($transaksi->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $transaksi
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

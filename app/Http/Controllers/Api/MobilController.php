<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Mobil;

class MobilController extends Controller
{
    public function showAllData()
    {
        $mobils = Mobil::all();

        if(count($mobils) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $mobils
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showAvailableMobils($stat)
    {
        // Stat 0 = Not Available
        // Stat 1 = Available
        $mobils = Mobil::where('statusMbl', $stat)->get(); 

        if(count($mobils) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $mobils
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $mobil = Mobil::find($id);

        if(!is_null($mobil))
        {
            return response([
                'message' => 'Success',
                'data'    => $mobil
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
            'namaMbl' => 'required',
            'urlFotoMbl' => 'required',
            'tipeMbl' => 'required',
            'jenisTransmisi' => 'required',
            'jenisBahanBakar' => 'required',
            'warna' => 'required',
            'volumeBahanBakar' => 'required|numeric',
            'kapasitasPenumpang' => 'required|numeric',
            'fasilitas' => 'required',
            'platNomor' => 'required',
            'noStnk' => 'required',
            'hargaSewa' => 'required|numeric',
            'periodeKontrakMulai' => 'required',
            'periodeKontrakAkhir' => 'required',
            'tglServisTerakhir' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $storeData['statusMbl'] = 1;
        if(is_null($storeData['idMitra']) || $storeData['idMitra'] <= 0)
        {
            $storeData['kategoriAset'] = 'Milik Perusahaan';
        }
        else
        {
            $storeData['kategoriAset'] = 'Milik Mitra';
        }

        $mobil = Mobil::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $mobil
        ], 200);
    }

    public function destroy($id)
    {
        $mobil = Mobil::find($id);
        if(is_null($mobil))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($mobil->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $mobil
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::find($id);
        if(is_null($mobil))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaMbl' => 'required',
            'urlFotoMbl' => 'required',
            'tipeMbl' => 'required',
            'jenisTransmisi' => 'required',
            'jenisBahanBakar' => 'required',
            'warna' => 'required',
            'volumeBahanBakar' => 'required|numeric',
            'kapasitasPenumpang' => 'required|numeric',
            'fasilitas' => 'required',
            'platNomor' => 'required',
            'noStnk' => 'required',
            'hargaSewa' => 'required|numeric',
            'periodeKontrakMulai' => 'required',
            'periodeKontrakAkhir' => 'required',
            'tglServisTerakhir' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $mobil->statusMbl = $mobil['statusMbl'];
        if(is_null($updateData['idMitra']) || $updateData['idMitra'] <= 0)
        {
            $updateData['kategoriAset'] = 'Milik Perusahaan';
        }
        else
        {
            $updateData['kategoriAset'] = 'Milik Mitra';
        }
        
        $mobil->idMitra = $updateData['idMitra'];
        $mobil->namaMbl = $updateData['namaMbl'];
        $mobil->urlFotoMbl = $updateData['urlFotoMbl'];
        $mobil->tipeMbl = $updateData['tipeMbl'];
        $mobil->jenisTransmisi = $updateData['jenisTransmisi'];
        $mobil->jenisBahanBakar = $updateData['jenisBahanBakar'];
        $mobil->warna = $updateData['warna'];
        $mobil->volumeBahanBakar = $updateData['volumeBahanBakar'];
        $mobil->kapasitasPenumpang = $updateData['kapasitasPenumpang'];
        $mobil->fasilitas = $updateData['fasilitas'];
        $mobil->platNomor = $updateData['platNomor'];
        $mobil->noStnk = $updateData['noStnk'];
        $mobil->hargaSewa = $updateData['hargaSewa'];
        $mobil->periodeKontrakMulai = $updateData['periodeKontrakMulai'];
        $mobil->periodeKontrakAkhir = $updateData['periodeKontrakAkhir'];
        $mobil->kategoriAset = $updateData['kategoriAset'];
        $mobil->tglServisTerakhir = $updateData['tglServisTerakhir'];

        if($mobil->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $mobil
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function ToggleSwitchStatusMobil($id)
    {
        $mobil = Mobil::find($id);
        if(is_null($mobil))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }
        
        if($mobil->statusMbl === 0)
        {
            $mobil->statusMbl = 1;
        }
        else if($mobil->statusMbl === 1)
        {
            $mobil->statusMbl = 0;
        }
        else
        {
            $mobil->statusMbl = 1;
        }
        
        $mobil->idMitra = $mobil['idMitra'];
        $mobil->namaMbl = $mobil['namaMbl'];
        $mobil->urlFotoMbl = $mobil['urlFotoMbl'];
        $mobil->tipeMbl = $mobil['tipeMbl'];
        $mobil->jenisTransmisi = $mobil['jenisTransmisi'];
        $mobil->jenisBahanBakar = $mobil['jenisBahanBakar'];
        $mobil->warna = $mobil['warna'];
        $mobil->volumeBahanBakar = $mobil['volumeBahanBakar'];
        $mobil->kapasitasPenumpang = $mobil['kapasitasPenumpang'];
        $mobil->fasilitas = $mobil['fasilitas'];
        $mobil->platNomor = $mobil['platNomor'];
        $mobil->noStnk = $mobil['noStnk'];
        $mobil->hargaSewa = $mobil['hargaSewa'];
        $mobil->periodeKontrakMulai = $mobil['periodeKontrakMulai'];
        $mobil->periodeKontrakAkhir = $mobil['periodeKontrakAkhir'];
        $mobil->kategoriAset = $mobil['kategoriAset'];
        $mobil->tglServisTerakhir = $mobil['tglServisTerakhir'];

        if($mobil->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $mobil
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

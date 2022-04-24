<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;
use App\Models\Driver;

class DriverController extends Controller
{
    public function showAllData()
    {
        $drivers = Driver::all();

        if(count($drivers) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $drivers
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showAvailableDrivers($stat)
    {
        // Stat 0 = Not Available
        // Stat 1 = Available
        $drivers = Driver::where('statusDrv', $stat)->get(); 

        if(count($drivers) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $drivers
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $driver = Driver::find($id);

        if(!is_null($driver))
        {
            return response([
                'message' => 'Success',
                'data'    => $driver
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
            'namaDrv' => 'required',
            'alamatDrv' => 'required',
            'tglLahirDrv' => 'required',
            'jenisKelaminDrv' => 'required',
            'emailDrv' => 'required|email:rfc,dns|unique:drivers',
            'noTelpDrv' => 'required|numeric|digits_between:10,13|phoneRules',
            'bahasaAsing' => 'required',
            'urlFotoDrv' => 'required',
            'simDrv' => 'required',
            'tarifDrv' => 'required|numeric',
            'suratBebasNapzaDrv' => 'required',
            'suratKesehatanJiwaDrv' => 'required',
            'suratKesehatanJasmaniDrv' => 'required',
            'skckDrv' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $prefix = "DRV-" . date('dmy');
        $temp = Driver::select('idDriver')->orderBy('idDriver','desc')->first();

        $id = $prefix . $temp->getID($temp['idDriver']);
        $storeData['idDriverGenerated'] = $id;

        $storeData['statusDrv'] = 1;
        $storeData['statusDokumenDrv'] = 0;
        $storeData['rerataRatingDrv'] = 0;
        $storeData['passwordDrv'] = $storeData['tglLahirDrv'];

        $Driver = Driver::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $Driver
        ], 200);
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);
        if(is_null($driver))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($driver->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $driver
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function updateRating(Request $request, $id)
    {
        $driver = Driver::find($id);
        if(is_null($driver))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'rerataRatingDrv' => 'required' ,
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $driver->rerataRatingDrv = $updateData['rerataRatingDrv'];

        $driver->idDriverGenerated = $driver['idDriverGenerated'];
        $driver->emailDrv = $driver['emailDrv'];
        $driver->statusDrv = $driver['statusDrv'];
        $driver->statusDokumenDrv = $driver['statusDokumenDrv'];
        $driver->passwordDrv = $driver['passwordDrv'];
        $driver->namaDrv = $driver['namaDrv'];
        $driver->alamatDrv = $driver['alamatDrv'];
        $driver->tglLahirDrv = $driver['tglLahirDrv'];
        $driver->jenisKelaminDrv = $driver['jenisKelaminDrv'];
        $driver->noTelpDrv = $driver['noTelpDrv'];
        $driver->bahasaAsing = $driver['bahasaAsing'];
        $driver->urlFotoDrv = $driver['urlFotoDrv'];
        $driver->simDrv = $driver['simDrv'];
        $driver->tarifDrv = $driver['tarifDrv'];
        $driver->suratBebasNapzaDrv = $driver['suratBebasNapzaDrv'];
        $driver->suratKesehatanJiwaDrv = $driver['suratKesehatanJiwaDrv'];
        $driver->suratKesehatanJasmaniDrv = $driver['suratKesehatanJasmaniDrv'];
        $driver->skckDrv = $driver['skckDrv'];

        if($driver->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $driver
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::find($id);
        if(is_null($driver))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $updateData['tglLahirDrv'] = Carbon::parse($updateData['tglLahirDrv'])->format('Y-m-d');
        $validate = Validator::make($updateData, [
            'namaDrv' => 'required',
            'alamatDrv' => 'required',
            'tglLahirDrv' => 'required',
            'jenisKelaminDrv' => 'required',
            'noTelpDrv' => 'required|numeric|digits_between:10,13|phoneRules',
            'bahasaAsing' => 'required',
            'urlFotoDrv' => 'required',
            'simDrv' => 'required',
            'tarifDrv' => 'required|numeric',
            'suratBebasNapzaDrv' => 'required',
            'suratKesehatanJiwaDrv' => 'required',
            'suratKesehatanJasmaniDrv' => 'required',
            'skckDrv' => 'required',
            'passwordDrv' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $driver->rerataRatingDrv = $driver['rerataRatingDrv'];
        $driver->idDriverGenerated = $driver['idDriverGenerated'];
        $driver->emailDrv = $driver['emailDrv'];
        $driver->statusDrv = $driver['statusDrv'];
        $driver->statusDokumenDrv = $driver['statusDokumenDrv'];

        $driver->passwordDrv = $updateData['passwordDrv'];
        $driver->namaDrv = $updateData['namaDrv'];
        $driver->alamatDrv = $updateData['alamatDrv'];
        $driver->tglLahirDrv = $updateData['tglLahirDrv'];
        $driver->jenisKelaminDrv = $updateData['jenisKelaminDrv'];
        $driver->noTelpDrv = $updateData['noTelpDrv'];
        $driver->bahasaAsing = $updateData['bahasaAsing'];
        $driver->urlFotoDrv = $updateData['urlFotoDrv'];
        $driver->simDrv = $updateData['simDrv'];
        $driver->tarifDrv = $updateData['tarifDrv'];
        $driver->suratBebasNapzaDrv = $updateData['suratBebasNapzaDrv'];
        $driver->suratKesehatanJiwaDrv = $updateData['suratKesehatanJiwaDrv'];
        $driver->suratKesehatanJasmaniDrv = $updateData['suratKesehatanJasmaniDrv'];
        $driver->skckDrv = $updateData['skckDrv'];

        if($driver->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $driver
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function ToggleSwitchStatusDriver($id)
    {
        $driver = Driver::find($id);
        if(is_null($driver))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }
        
        if($driver->statusDrv === 0)
        {
            $driver->statusDrv = 1;
        }
        else if($driver->statusDrv === 1)
        {
            $driver->statusDrv = 0;
        }
        else
        {
            $driver->statusDrv = 1;
        }

        $driver->idDriverGenerated = $driver['idDriverGenerated'];
        $driver->statusDokumenDrv = $driver['statusDokumenDrv'];
        $driver->emailDrv = $driver['emailDrv'];
        $driver->passwordDrv = $driver['passwordDrv'];
        $driver->rerataRatingDrv = $driver['rerataRatingDrv'];
        $driver->namaDrv = $driver['namaDrv'];
        $driver->alamatDrv = $driver['alamatDrv'];
        $driver->tglLahirDrv = $driver['tglLahirDrv'];
        $driver->jenisKelaminDrv = $driver['jenisKelaminDrv'];
        $driver->noTelpDrv = $driver['noTelpDrv'];
        $driver->bahasaAsing = $driver['bahasaAsing'];
        $driver->urlFotoDrv = $driver['urlFotoDrv'];
        $driver->simDrv = $driver['simDrv'];
        $driver->tarifDrv = $driver['tarifDrv'];
        $driver->suratBebasNapzaDrv = $driver['suratBebasNapzaDrv'];
        $driver->suratKesehatanJiwaDrv = $driver['suratKesehatanJiwaDrv'];
        $driver->suratKesehatanJasmaniDrv = $driver['suratKesehatanJasmaniDrv'];
        $driver->skckDrv = $driver['skckDrv'];

        if($driver->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $driver
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function ToggleSwitchStatusDokumenDriver($id)
    {
        $driver = Driver::find($id);
        if(is_null($driver))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }
        
        if($driver->statusDokumenDrv === 0)
        {
            $driver->statusDokumenDrv = 1;
        }
        else if($driver->statusDokumenDrv === 1)
        {
            $driver->statusDokumenDrv = 0;
        }
        else
        {
            $driver->statusDokumenDrv = 1;
        }

        $driver->idDriverGenerated = $driver['idDriverGenerated'];
        $driver->emailDrv = $driver['emailDrv'];
        $driver->passwordDrv = $driver['passwordDrv'];
        $driver->rerataRatingDrv = $driver['rerataRatingDrv'];
        $driver->namaDrv = $driver['namaDrv'];
        $driver->alamatDrv = $driver['alamatDrv'];
        $driver->tglLahirDrv = $driver['tglLahirDrv'];
        $driver->jenisKelaminDrv = $driver['jenisKelaminDrv'];
        $driver->noTelpDrv = $driver['noTelpDrv'];
        $driver->bahasaAsing = $driver['bahasaAsing'];
        $driver->urlFotoDrv = $driver['urlFotoDrv'];
        $driver->simDrv = $driver['simDrv'];
        $driver->tarifDrv = $driver['tarifDrv'];
        $driver->suratBebasNapzaDrv = $driver['suratBebasNapzaDrv'];
        $driver->suratKesehatanJiwaDrv = $driver['suratKesehatanJiwaDrv'];
        $driver->suratKesehatanJasmaniDrv = $driver['suratKesehatanJasmaniDrv'];
        $driver->skckDrv = $driver['skckDrv'];

        if($driver->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $driver
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

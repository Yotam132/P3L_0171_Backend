<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function showAllData()
    {
        $pegawais = Pegawai::all();

        if(count($pegawais) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $pegawais
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function GetCustomerService()
    {
        $pegawais = Pegawai::where('idRole', 2)->get();

        if(count($pegawais) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $pegawais
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $pegawai = Pegawai::find($id);

        if(!is_null($pegawai))
        {
            return response([
                'message' => 'Success',
                'data'    => $pegawai
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
            'namaPgw' => 'required',
            'alamatPgw' => 'required',
            'tglLahirPgw' => 'required',
            'jenisKelaminPgw' => 'required',
            'emailPgw' => 'required|email:rfc,dns|unique:pegawais',
            'noTelpPgw' => 'required|numeric|digits_between:10,13|phoneRules',
            'urlFotoPgw' => 'required',
            'idRole' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $storeData['jumlahShiftPgw'] = 0;
        $storeData['passwordPgw'] = $storeData['tglLahirPgw'];
        $pegawai = Pegawai::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $pegawai
        ], 200);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        if(is_null($pegawai))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($pegawai->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        if(is_null($pegawai))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPgw' => 'required',
            'alamatPgw' => 'required',
            'tglLahirPgw' => 'required',
            'jenisKelaminPgw' => 'required',
            'noTelpPgw' => 'required|numeric|digits_between:10,13|phoneRules',
            'urlFotoPgw' => 'required',
            'idRole' => 'required|numeric',
            'passwordPgw' => 'required'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $pegawai->emailPgw = $pegawai['emailPgw'];
        $pegawai->jumlahShiftPgw = $pegawai['jumlahShiftPgw'];
        
        $pegawai->passwordPgw = $updateData['passwordPgw'];
        $pegawai->namaPgw = $updateData['namaPgw'];
        $pegawai->alamatPgw = $updateData['alamatPgw'];
        $pegawai->tglLahirPgw = $updateData['tglLahirPgw'];
        $pegawai->jenisKelaminPgw = $updateData['jenisKelaminPgw'];
        $pegawai->noTelpPgw = $updateData['noTelpPgw'];
        $pegawai->urlFotoPgw = $updateData['urlFotoPgw'];
        $pegawai->idRole = $updateData['idRole'];

        if($pegawai->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function incrementOrDecrementJumlahShift($id, $value)
    {
        // Value -1 = Decrement
        // Value 1 = Increment
        
        $pegawai = Pegawai::find($id);
        if(is_null($pegawai))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        if($value < 0)
        {
            $pegawai->jumlahShiftPgw -= 1;
            if($pegawai->jumlahShiftPgw < 0)
            {
                $pegawai->jumlahShiftPgw = 0;
            }
        }        
        else
        {
            if($pegawai->jumlahShiftPgw + 1 > 6)
            {
                return response([
                    'message' => 'Pegawai sudah mencapai jumlah shift maximal',
                    'data'    => null
                ], 400);
            }
            
            $pegawai->jumlahShiftPgw += 1;
        }


        $pegawai->emailPgw = $pegawai['emailPgw'];
        $pegawai->passwordPgw = $pegawai['passwordPgw'];
        $pegawai->namaPgw = $pegawai['namaPgw'];
        $pegawai->alamatPgw = $pegawai['alamatPgw'];
        $pegawai->tglLahirPgw = $pegawai['tglLahirPgw'];
        $pegawai->jenisKelaminPgw = $pegawai['jenisKelaminPgw'];
        $pegawai->noTelpPgw = $pegawai['noTelpPgw'];
        $pegawai->urlFotoPgw = $pegawai['urlFotoPgw'];
        $pegawai->idRole = $pegawai['idRole'];
 
        if($pegawai->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

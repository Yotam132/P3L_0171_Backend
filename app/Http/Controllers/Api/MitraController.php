<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Mitra;

class MitraController extends Controller
{
    public function showAllData()
    {
        $mitras = Mitra::all();

        if(count($mitras) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $mitras
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $mitra = Mitra::find($id);

        if(!is_null($mitra))
        {
            return response([
                'message' => 'Success',
                'data'    => $mitra
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
            'namaMtr' => 'required',
            'noKtpMtr' => 'required|numeric',
            'alamatMtr' => 'required',
            'noTelpMtr' => 'required|numeric|digits_between:10,13|phoneRules',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $mitra = Mitra::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $mitra
        ], 200);
    }

    public function destroy($id)
    {
        $mitra = Mitra::find($id);
        if(is_null($mitra))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($mitra->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $mitra
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $mitra = Mitra::find($id);
        if(is_null($mitra))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaMtr' => 'required',
            'noKtpMtr' => 'required|numeric',
            'alamatMtr' => 'required',
            'noTelpMtr' => 'required|numeric|digits_between:10,13|phoneRules',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $mitra->namaMtr = $updateData['namaMtr'];
        $mitra->noKtpMtr = $updateData['noKtpMtr'];
        $mitra->alamatMtr = $updateData['alamatMtr'];
        $mitra->noTelpMtr = $updateData['noTelpMtr'];

        if($mitra->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $mitra
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

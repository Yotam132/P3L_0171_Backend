<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\DetailJadwal;

class DetailJadwalController extends Controller
{
    public function showAllData()
    {
        $details = DetailJadwal::all();

        if(count($details) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $details
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $detail = DetailJadwal::find($id);

        if(!is_null($detail))
        {
            return response([
                'message' => 'Success',
                'data'    => $detail
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
            'idJadwal' => 'required|numeric',
            'idPegawai' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $DetailJadwal = DetailJadwal::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $DetailJadwal
        ], 200);
    }

    public function destroy($id)
    {
        $detail = DetailJadwal::find($id);
        if(is_null($detail))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($detail->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $detail
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $detail = DetailJadwal::find($id);
        if(is_null($detail))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'idJadwal' => 'required|numeric',
            'idPegawai' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $detail->idJadwal = $updateData['idJadwal'];
        $detail->idPegawai = $updateData['idPegawai'];
        
        if($detail->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $detail
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function showAllData()
    {
        $jadwals = Jadwal::all();

        if(count($jadwals) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $jadwals
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $jadwal = Jadwal::find($id);

        if(!is_null($jadwal))
        {
            return response([
                'message' => 'Success',
                'data'    => $jadwal
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
            'hari' => 'required',
            'nomorShift' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $jadwal = Jadwal::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $jadwal
        ], 200);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        if(is_null($jadwal))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($jadwal->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $jadwal
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        if(is_null($jadwal))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'hari' => 'required',
            'nomorShift' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $jadwal->hari = $updateData['hari'];
        $jadwal->nomorShift = $updateData['nomorShift'];

        if($jadwal->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $jadwal
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

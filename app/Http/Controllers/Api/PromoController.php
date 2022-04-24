<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Promo;

class PromoController extends Controller
{
    public function showAllData()
    {
        $promos = Promo::all();

        if(count($promos) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $promos
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showActivePromos($stat)
    {
        // Stat 0 = Not Available
        // Stat 1 = Available
        $promos = Promo::where('statusPrm', $stat)->get(); 

        if(count($promos) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $promos
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $promo = Promo::find($id);

        if(!is_null($promo))
        {
            return response([
                'message' => 'Success',
                'data'    => $promo
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
            'kodePrm' => 'required',
            'jenisPrm' => 'required',
            'keteranganPrm' => 'required',
            'diskonPrm' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $storeData['statusPrm'] = 1;

        $promo = Promo::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $promo
        ], 200);
    }

    public function destroy($id)
    {
        $promo = Promo::find($id);
        if(is_null($promo))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($promo->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $promo
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        if(is_null($promo))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'kodePrm' => 'required',
            'jenisPrm' => 'required',
            'keteranganPrm' => 'required',
            'diskonPrm' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $promo->statusPrm = $promo['statusPrm'];
        
        $promo->kodePrm = $updateData['kodePrm'];
        $promo->jenisPrm = $updateData['jenisPrm'];
        $promo->keteranganPrm = $updateData['keteranganPrm'];
        $promo->diskonPrm = $updateData['diskonPrm'];


        if($promo->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $promo
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function ToggleSwitchStatusPromo($id)
    {
        $promo = Promo::find($id);
        if(is_null($promo))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }
        
        if($promo->statusPrm === 0)
        {
            $promo->statusPrm = 1;
        }
        else if($promo->statusPrm === 1)
        {
            $promo->statusPrm = 0;
        }
        else
        {
            $promo->statusPrm = 1;
        }
        
        $promo->kodePrm = $promo['kodePrm'];
        $promo->jenisPrm = $promo['jenisPrm'];
        $promo->keteranganPrm = $promo['keteranganPrm'];
        $promo->diskonPrm = $promo['diskonPrm'];

        if($promo->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $promo
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

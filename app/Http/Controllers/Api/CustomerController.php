<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function showAllData()
    {
        $custs = Customer::all();

        if(count($custs) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $custs
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $cust = Customer::find($id);

        if(!is_null($cust))
        {
            return response([
                'message' => 'Success',
                'data'    => $cust
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
            'namaCust' => 'required',
            'alamatCust' => 'required',
            'tglLahirCust' => 'required',
            'jenisKelaminCust' => 'required',
            'emailCust' => 'required|email:rfc,dns|unique:customers',
            'noTelpCust' => 'required|numeric|digits_between:10,13|phoneRules',
            'kartuPengenalCust' => 'required',
            'simCust' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $storeData['statusDokumenCust'] = 0;

        $prefix = "CUS" . date('ymd') . "-";
        $tempCus = Customer::select('idCustomer')->orderBy('idCustomer','desc')->first();

        $id = $prefix . $tempCus->getID($tempCus['idCustomer']);
        $storeData['idCustomerGenerated'] = $id;
        $storeData['passwordCust'] = $storeData['tglLahirCust'];

        $customer = Customer::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $customer
        ], 200);
    }

    public function destroy($id)
    {
        $cust = Customer::find($id);
        if(is_null($cust))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($cust->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $cust
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $cust = Customer::find($id);
        if(is_null($cust))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaCust' => 'required',
            'alamatCust' => 'required',
            'tglLahirCust' => 'required',
            'jenisKelaminCust' => 'required',
            'noTelpCust' => 'required|numeric|digits_between:10,13|phoneRules',
            'kartuPengenalCust' => 'required',
            'simCust' => 'required',
            'passwordCust' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $cust->idCustomerGenerated = $cust['idCustomerGenerated'];
        $cust->statusDokumenCust = $cust['statusDokumenCust'];
        $cust->namaCust = $updateData['namaCust'];
        $cust->alamatCust = $updateData['alamatCust'];
        $cust->tglLahirCust = $updateData['tglLahirCust'];
        $cust->jenisKelaminCust = $updateData['jenisKelaminCust'];
        $cust->emailCust = $cust['emailCust'];
        $cust->noTelpCust = $updateData['noTelpCust'];
        $cust->kartuPengenalCust = $updateData['kartuPengenalCust'];
        $cust->simCust = $updateData['simCust'];
        $cust->passwordCust = $updateData['passwordCust'];

        if($cust->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $cust
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }

    public function ToggleSwitchStatusDokumenCustomer($id)
    {
        $cust = Customer::find($id);
        if(is_null($cust))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }
        
        if($cust->statusDokumenCust === 0)
        {
            $cust->statusDokumenCust = 1;
        }
        else if($cust->statusDokumenCust === 1)
        {
            $cust->statusDokumenCust = 0;
        }
        else
        {
            $cust->statusDokumenCust = 0;
        }

        $cust->idCustomerGenerated = $cust['idCustomerGenerated'];
        $cust->namaCust = $cust['namaCust'];
        $cust->alamatCust = $cust['alamatCust'];
        $cust->tglLahirCust = $cust['tglLahirCust'];
        $cust->jenisKelaminCust = $cust['jenisKelaminCust'];
        $cust->emailCust = $cust['emailCust'];
        $cust->noTelpCust = $cust['noTelpCust'];
        $cust->kartuPengenalCust = $cust['kartuPengenalCust'];
        $cust->simCust = $cust['simCust'];
        $cust->passwordCust = $cust['passwordCust'];

        if($cust->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $cust
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

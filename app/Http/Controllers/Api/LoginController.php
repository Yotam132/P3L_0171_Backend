<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Customer;
use App\Models\Pegawai;
use App\Models\Driver;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
     
        /**
         * 1 itu Customer
         * 2 itu Pegawai
         * 3 itu Driver
         */
        
        if($loginData['no'] === '1')
        {
            $userLogin = Customer::where('emailCust', $loginData['email'])->where('passwordCust', $loginData['password'])->first();
            if(!is_null($userLogin))
            {
                return response([
                    'message' => 'Berhasil Login!',
                    'data' => $userLogin
                ], 200);
            }
            else
            {
                return response([
                    'message' => 'Email / Password Salah!',
                    'data' => null
                ], 400);
            }

        }
        else if($loginData['no'] === '2')
        {
            $userLogin = Pegawai::where('emailPgw', $loginData['email'])->where('passwordPgw', $loginData['password'])->first();
            if(!is_null($userLogin))
            {
                return response([
                    'message' => 'Berhasil Login!',
                    'data' => $userLogin
                ], 200);
            }
            else
            {
                return response([
                    'message' => 'Email / Password Salah!',
                    'data' => null
                ], 400);
            }

        }
        else if($loginData['no'] === '3')
        {
            $userLogin = Driver::where('emailDrv', $loginData['email'])->where('passwordDrv', $loginData['password'])->first();
            if(!is_null($userLogin))
            {
                return response([
                    'message' => 'Berhasil Login!',
                    'data' => $userLogin
                ], 200);
            }
            else
            {
                return response([
                    'message' => 'Email / Password Salah!',
                    'data' => null
                ], 400);
            }

        }
        else
        {
            return response([
                'message' => 'Nomor yang diparsing ke backend tidak ada!',
                'data' => null
            ], 400);
        }
    }
}

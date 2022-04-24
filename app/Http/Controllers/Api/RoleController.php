<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Tambahan dibawah ini

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Role;

class RoleController extends Controller
{
    public function showAllData()
    {
        $roles = Role::all();

        if(count($roles) > 0)
        {
            return response([
                'message' => 'Success',
                'data'    => $roles
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'    => null
        ], 400);
    }

    public function showById($id)
    {
        $role = Role::find($id);

        if(!is_null($role))
        {
            return response([
                'message' => 'Success',
                'data'    => $role
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
            'namaRole' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $role = Role::create($storeData);

        return response([
            'message' => 'Add Success',
            'data'    => $role
        ], 200);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if(is_null($role))
        {
            return response([
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        if($role->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data'    => $role
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data'    => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if(is_null($role))
        {
            return response([
                'message' => 'Not Found',
                'data'    => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaRole' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $role->namaRole = $updateData['namaRole'];

        if($role->save())
        {
            return response([
                'message' => 'Update Success',
                'data'    => $role
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data'    => null
        ], 400);
    }
}

<?php

namespace App\Http\Controllers;

use App\ModelsView\ViewUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $users = QueryBuilder::for(ViewUsers::class,$request)->allowedFilters('id','name','email','created_at','updated_at','role')->allowedSorts(['id','name','email','created_at','updated_at','role'])->paginate($limit);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles(['user']);

        return response()->json([
            'message' => 'Insert Success',
            'data' => $user
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',

        ]);

        if ($request->password) {
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }else{
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }

        return response()->json([
            'message' => 'Update Success',
            'data' => $user
        ]);
    }

    public function delete(Request $request)
    {
        User::find($request->id)->delete();
        return response()->json(['message'=>'User deleted']);
    }
}

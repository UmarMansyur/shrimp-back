<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['register']]);
    }

    public function create(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'name' => 'required|string|unique:users',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required:string',
                    'role' => 'required|string'
                ],
                [
                    'name.unique' => 'Name already exists',
                    'name.required' => 'Name is required',
                    'email.required' => 'Email is required',
                    'email.email' => 'Email is invalid',
                    'email.unique' => 'Email already exists',
                    'password.required' => 'Password is required',
                    'role.required' => 'Role is required',
                ]
            );
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'user'
            ]);
            UserDetail::create([
                'user_id' => $user->id
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Registered successfully'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        try {
            $users = User::all();
            if ($users) {
                return response()->json([
                    'status' => true,
                    'data' => $users
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'No users found'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found',
                ]);
            }
            $newData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'thumbnail' => $request->thumbnail
            ];
            $user->fill($newData);
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found'
                ], 404);
            }
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

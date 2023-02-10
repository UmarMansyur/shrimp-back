<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;

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
            $limit = request('limit') ?? 10;
            $page = request('page') ?? 1;
            $offset = ($page - 1) / $limit;
            $users = DB::select("SELECT users.*, user_details.id as user_detail_id, address, phone FROM users JOIN user_details ON users.id = user_details.user_id LIMIT $limit OFFSET $offset");
            if ($users) {
                return response()->json([
                    'status' => true,
                    'data' => $users
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Retrived Successfully',
                'data' => [
                    'current_page' => $page,
                    'total_pages' => ceil(User::count() / $limit),
                    'total_datas' => User::count(),
                    'limit' => $limit,
                    'data' => $users
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function showById($id) {
        try {
            $exist = DB::select('SELECT users.*, user_details.id as user_detail_id, address, phone FROM users JOIN user_details ON users.id = user_details.user_id WHERE users.id = ?', [$id]);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anco Not Found'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data retrived successfully',
                'data' => $exist
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
            $userDetail = UserDetail::where('user_id', $id)->first();
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
            $newDataUser = [
                'address' => $request->address,
                'phone' => $request->phone
            ];
            $user->fill($newData);
            $userDetail->fill($newDataUser);
            $user->save();
            $userDetail->save();
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

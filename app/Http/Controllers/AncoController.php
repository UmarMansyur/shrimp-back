<?php

namespace App\Http\Controllers;

use App\Models\Anco;
use Illuminate\Http\Request;

class AncoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        try {

            $this->validate($request, [
                'name'       => 'required|string|unique:anco_types'
            ]);

            Anco::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Ancos Created Successfully'
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
            $exist = Anco::find($id);
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

    public function show()
    {
        try {
            $exist = Anco::all();
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
            $exist = Anco::find($id);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anco Not Found'
                ], 404);
            }
            $exist->fill($request->all());
            $exist->save();
            return response()->json([
                'status' => true,
                'message' => 'Anco Updated Successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $exist = Anco::find($id);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anco Not Found'
                ], 404);
            }
            $exist->delete();
            return response()->json([
                'status' => true,
                'message' => 'Anco Deleted Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pond;
use Illuminate\Http\Request;

class PondController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create(Request $request)
    {
        try {

            $this->validate($request, [
                'name'       => 'required|string|unique:ponds',
                'wide'       => 'required|numeric|min:1|max:99999',
                'stock_date' => 'required|date'
            ]);

            Pond::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Ponds Created Successfully'
            ]);
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
            $exist = Pond::all();
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pond Not Found'
                ], 404);
            }
            return response()->json([
                'status' => false,
                'message' => 'Pond Not Found',
                'data' => $exist
            ], 404);
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
            $exist = Pond::find($id);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pond Not Found'
                ], 404);
            }
            $exist->fill($request->all());
            $exist->save();
            return response()->json([
                'status' => true,
                'message' => 'Pond Updated Successfully',
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
            $exist = Pond::find($id);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pond Not Found'
                ], 404);
            }
            $exist->delete();
            return response()->json([
                'status' => true,
                'message' => 'Pond Deleted Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

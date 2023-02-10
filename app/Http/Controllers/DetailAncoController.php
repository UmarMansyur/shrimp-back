<?php

namespace App\Http\Controllers;

use App\Models\DetailAnco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DetailAncoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        try {
            DetailAnco::create($request->all());
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
            $exist = DetailAnco::find($id)->with('anco_type')->with('pond')->get();
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

    public function showToday()
    {
        try {
            $limit = request('limit') ?? 10;
            $page = request('page') ?? 1;
            $offset = ($page - 1) * $limit;
            $exist = DB::select("SELECT ancos.id as id, duration, ponds.name as pond_name, anco_types.name as anco_type, ancos.started_time, ancos.finished_time, ancos.created_at, ancos.updated_at FROM ancos INNER JOIN ponds ON ancos.pond_id = ponds.id INNER JOIN anco_types ON ancos.anco_type_id = anco_types.id WHERE DATE(ancos.created_at) = CURDATE() LIMIT $limit OFFSET $offset");
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

    public function show() {
        try {
            $limit = request('limit') ?? 10;
            $page = request('page') ?? 1;
            $offset = ($page - 1) * $limit;
            $exist = DB::select("SELECT ancos.*, ponds.name as pond_name, anco_types.name as anco_type FROM ancos INNER JOIN ponds ON ancos.pond_id = ponds.id INNER JOIN anco_types ON ancos.anco_type_id = anco_types.id ORDER BY ancos.id LIMIT $limit OFFSET $offset");
            return response()->json([
                'status' => true,
                'message' => 'Data Retrived Successfully',
                'data' => [
                    'current_page' => $page,
                    'total_pages' => ceil(DetailAnco::count() / $limit),
                    'total_datas' => DetailAnco::count(),
                    'limit' => $limit,
                    'data' => $exist
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $exist = DetailAnco::find($id);
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
            $exist = DetailAnco::find($id);
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

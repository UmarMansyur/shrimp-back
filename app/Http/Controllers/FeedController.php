<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        try {
            Feed::create($request->all());
            return response()->json([
                'status'  => true,
                'message' => 'Data Created Successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function showById($id)
    {
        try {
            $exist = DB::select("SELECT feeds.*, ponds.name as pond_name FROM feeds INNER JOIN ponds ON feeds.pond_id = ponds.id WHERE feeds.id = $id");
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
            $offset = ($page - 1) / $limit;
            $exist = DB::select("SELECT feeds.*, ponds.name as pond_name FROM feeds INNER JOIN ponds ON feeds.pond_id = ponds.id WHERE DATE(feeds.created_at) = CURDATE() LIMIT $limit OFFSET $offset");
            return response()->json([
                'status' => true,
                'message' => 'Data Retrived Successfully',
                'data' => $exist
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
            $limit = request('limit') ?? 10;
            $page = request('page') ?? 1;
            $offset = ($page - 1) / $limit;
            $exist = DB::select("SELECT feeds.*, ponds.name as pond_name FROM feeds INNER JOIN ponds ON feeds.pond_id = ponds.id LIMIT $limit OFFSET $offset");
            return response()->json([
                'status' => true,
                'message' => 'Data Retrived Successfully',
                'data' => [
                    'current_page' => $page,
                    'total_pages' => ceil(Feed::count() / $limit),
                    'total_datas' => Feed::count(),
                    'limit' => $limit,
                    'data' => $exist
                ]
            ]);
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
            $exist = Feed::find($id);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found'
                ], 404);
            }
            $exist->fill($request->all());
            $exist->save();
            return response()->json([
                'status' => true,
                'message' => 'Data Updated Successfully',
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
            $exist = Feed::find($id);
            if (!$exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found'
                ], 404);
            }
            $exist->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data Deleted Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

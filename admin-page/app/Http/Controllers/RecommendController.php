<?php

namespace App\Http\Controllers;

use App\Models\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecommendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public static function addRecommendation($contentId, $recommend = false)
    {
        $recommendation = new Recommend([
            'contents_id' => $contentId,
            'recommended_flag' => $recommend
        ]);
        $recommendation->save();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->addRecommendation($request->id);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'recommended_flag' => 'required|boolean',
        ]);

        try {
            Log::info('Request Data:', $request->all());
            Log::info('Request id:', ['id' => $id]);

            $update = [
                'recommended_flag' => $request->recommended_flag,
            ];

            DB::enableQueryLog();

            // 更新処理実行
            $result = Recommend::where('contents_id', $id)->update($update);

            // クエリログの出力
            $log = DB::getQueryLog();
            Log::info('Database Query Log:', $log);
            Log::info('Update Result:', ['result' => $result]);

            if ($result) {
                return response()->json(['message' => 'Recommendation status updated successfully!'], 200);
            } else {
                return response()->json(['message' => 'No changes made to the recommendation status.'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update the recommendation status: ' . $e->getMessage()], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

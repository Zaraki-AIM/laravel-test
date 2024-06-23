<?php

namespace App\Http\Controllers;

use App\Models\Contents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Contents::query();

        if ($request->has('grade') && $request->get('grade') != '') {
            $grade = $request->get('grade');
            $query->whereJsonContains('grade', $grade);
        }

        // ページネーションを適用（3件ずつ表示）
        $contents = $query->orderBy('created_at', 'desc')->get();

        return response()
            ->view('index', ['contents' => $contents, 'grade' => $request->get('grade')])
            ->header('Content-Type', 'text/html')
            ->header('Content-Encoding', 'UTF-8');
    }



    // コンテンツ作成画面表示
    public function create()
    {
        return view("create_contents");
    }

    // コンテンツ登録処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required|integer',
            'grade' => 'nullable|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 'required'に変更して一度にバリデーション
        ]);

        $content = new Contents([
            'title' => $request->input('title'), // get() の代わりに input() を使うことが一般的です
            'status' => $request->input('status'),
            'grade' => $request->input('grade'), // 直接inputメソッドを使用
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info("Uploading: " . $file->getClientOriginalName() . " Size: " . $file->getSize());
            $path = Storage::disk('s3')->put('images', $file, 'public');
            if ($path) {
                Log::info("Uploaded: " . $path);
                $content->image = $path;
            } else {
                Log::error("Failed to upload");
            }
            $content->save();

            RecommendController::addRecommendation($content->id);

            return redirect()->route('contents.index')
                ->with('success', 'Content created successfully with image stored in S3.');
        } else {
            Log::error("No file present in the request.");
        }
    }


    public function destroy($id)
    {
        $content = Contents::findOrFail($id);
        $content->delete();

        return redirect()->route('contents.index')
            ->with('success', 'Content deleted successfully.');
    }
}

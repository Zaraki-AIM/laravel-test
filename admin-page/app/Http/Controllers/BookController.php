<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllBooks()
    {
        // 書籍データを全て取得
        $books = Book::all();

        // レスポンスをJSON形式で返す
        return response()->json([
            'success' => true,
            'data' => $books
        ], Response::HTTP_OK); // HTTP ステータスコード 200
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBook(StoreBookRequest $request)
    {
        // リクエストボディを解析して、登録処理を行う
        $book = Book::createInstance([
            'title' => $request->title,
            'author' => $request->author,
            'genre' => $request->genre,
            'published_date' => $request->published_date,
            'status' => $request->status
        ]);

        $book->save();

        // 登録後の書籍情報とステータスコード201を返す
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function getBookDetail(string $id)
    {
        $book = Book::where('id', $id)->get();
        // レスポンスをJSON形式で返す
        return response()->json([
            'success' => true,
            'data' => $book
        ], Response::HTTP_OK); // HTTP ステータスコード 200
    }

    /**
     * Update the specified resource in storage.
     */
    public function editBookDetail(StoreBookRequest $request, string $id)
    {
        $update = [
            'title' => $request->title,
            'author' => $request->author,
            'genre' => $request->genre,
            'published_date' => $request->published_date,
        ];

        Book::where('id', $id)->update($update);
        return response()->json(['message' => 'Book updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteBook(string $id)
    {
        //
    }
}

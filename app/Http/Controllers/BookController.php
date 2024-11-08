<?php
// Code by: @DEV_Phuong
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $books = Book::all();
        return response()->json($books, 200);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'title' => 'required|string',
                'author_id' => 'required|exists:authors,id',
                'description' => 'required|string',
                'published_date' => 'required',
            ]);
            $book = Book::create($request->all());
            return response()->json(['message' => 'Created book successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        $book = Book::find($id);
        return response()->json($book, 200);
    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'title' => 'required|sometimes',
                'author_id' => 'required|sometimes',
                'description' => 'required|sometimes',
                'published_date' => 'required|sometimes',
        ]);
        $book = Book::find($id);
        $book->update($request->all());
            return response()->json(['message' => 'Updated book successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        $book = Book::find($id);
        $book->delete();
        return response()->json(['message' => 'Deleted book successfully'], 200);
    }
}

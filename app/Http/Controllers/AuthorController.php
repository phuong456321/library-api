<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(){
        $authors = Author::all();
        return response()->json($authors);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'name' => 'required',
                'bio' => 'required',
        ]);
        $author = Author::create($request->all());
            return response()->json(['message' => 'Created author successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        $author = Author::find($id);
        return response()->json($author, 200);
    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'name' => 'required|string|sometimes',
                'bio' => 'required|string|sometimes',
        ]);
        $author = Author::find($id);
        $author->update($request->all());
            return response()->json(['message' => 'Updated author successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        $author = Author::find($id);
        $author->delete();
        return response()->json(['message' => 'Deleted author successfully'], 200);
    }
}

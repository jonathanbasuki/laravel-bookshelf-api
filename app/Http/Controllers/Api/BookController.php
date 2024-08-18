<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookController extends Controller
{
    protected $token;

    public function index()
    {
        $books = Book::latest()->paginate(5);

        return response()->json($books, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'published' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'pages' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong! Check your input.',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create([
            'user_id' => Auth::id(),
            'isbn' => $request->isbn,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'author' => $request->author,
            'published' => $request->published,
            'publisher' => $request->publisher,
            'pages' => $request->pages,
            'description' => $request->description,
            'website' => $request->website,
        ]);

        return response()->json([
            'message' => 'Book created.',
            'book' => [
                'id' => $book->id,
                'user_id' => $book->user_id,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'subtitle' => $book->subtitle,
                'author' => $book->author,
                'published' => $book->published,
                'publisher' => $book->publisher,
                'pages' => $book->pages,
                'description' => $book->description,
                'website' => $book->website,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ],
        ], 200);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'message' => 'No query results for model [App\\Models\\Book] 999.'
            ], 404);
        }

        if ($book->user_id != Auth::id()) {
            return response()->json([
                'message' => 'This action is unauthorized.'
            ], 403);
        }

        return response()->json([
            'id' => $book->id,
            'user_id' => $book->user_id,
            'isbn' => $book->isbn,
            'title' => $book->title,
            'subtitle' => $book->subtitle,
            'author' => $book->author,
            'published' => $book->published,
            'publisher' => $book->publisher,
            'pages' => $book->pages,
            'description' => $book->description,
            'created_at' => $book->created_at,
            'updated_at' => $book->updated_at,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'published' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'pages' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong! Check your input.',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'message' => 'No query results for model [App\\Models\\Book] 999.'
            ], 404);
        }

        if ($book->user_id != Auth::id()) {
            return response()->json([
                'message' => 'This action is unauthorized.'
            ], 403);
        }

        $book->update($request->only([
            'isbn',
            'title',
            'subtitle',
            'author',
            'published',
            'publisher',
            'pages',
            'description',
            'website',
        ]));

        return response()->json($book, 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'message' => 'No query results for model [App\\Models\\Book] 999.'
            ], 404);
        }

        if ($book->user_id != Auth::id()) {
            return response()->json([
                'message' => 'This action is unauthorized.'
            ], 403);
        }

        Book::destroy($id);

        return response()->json([
            'message' => 'Book deleted.',
            'book' => [
                'id' => $book->id,
                'user_id' => $book->user_id,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'subtitle' => $book->subtitle,
                'author' => $book->author,
                'published' => $book->published,
                'publisher' => $book->publisher,
                'pages' => $book->pages,
                'description' => $book->description,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at
            ],
        ], 200);
    }
}

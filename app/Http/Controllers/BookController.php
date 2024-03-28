<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookController extends Controller
{
    public function index()
    {
        if (JWTAuth::user()->cannot('index', Book::class)) {
            return response()->json(['message' => 'Permission denied'], 403);
        } else {
            $books = Book::all();

            if ($books->count() == 0) {
                return response()->json(['books' => 'No records found'], 404);
            } else {
                return response()->json(['books' => $books], 200);
            }
        }
    }

    public function store(BookStoreRequest $request)
    {
        if (JWTAuth::user()->cannot('index', Book::class)) {
            return response()->json(['message' => 'Permission denied'], 403);
        } else {
            $image = Str::random(32) . "." . $request->cover->getClientOriginalExtension();

            Book::create([
                'title' => $request->title,
                'cover' => $image,
                'author' => $request->author,
                'genre' => $request->genre,
                'series' => $request->series,
                'description' => $request->description,
                'isbn' => $request->isbn,
                'publisher' => $request->publisher,
                'pages' => $request->pages
            ]);

            Storage::disk('public')->put($image, file_get_contents($request->cover));

            return response()->json(['message' => 'Book successfully added'], 200);
        }
    }

    public function show($id)
    {
        $book = Book::find($id);
        $user = JWTAuth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } else {
            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            } else {
                return response()->json(['book' => $book], 200);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'cover' => 'image',
            'author' => 'required|string',
            'genre' => 'required|string',
            'series' => 'string',
            'description' => 'required|string',
            'isbn' => [
                'required',
                'string',
                Rule::unique('books')->ignore($id)
            ],
            'publisher' => 'required|string',
            'pages' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        } else {
            if (JWTAuth::user()->cannot('index', Book::class)) {
                return response()->json(['message' => 'Permission denied'], 403);
            } else {
                $book = Book::find($id);

                if (!$book) {
                    return response()->json(['message' => 'Book not found'], 404);
                } else {
                    $storage = Storage::disk('public');

                    $book->update([
                        'title' => $request->title,
                        'author' => $request->author,
                        'genre' => $request->genre,
                        'series' => $request->series,
                        'description' => $request->description,
                        'isbn' => $request->isbn,
                        'publisher' => $request->publisher,
                        'pages' => $request->pages
                    ]);

                    if ($request->cover) {
                        $storage->delete($book->cover);
                        $image = Str::random(32) . "." . $request->cover->getClientOriginalExtension();
                        $book->cover = $image;
                        $storage->put($image, file_get_contents($request->cover));
                    }
                    $book->save();

                    return response()->json(['message' => 'Book successfully updated'], 200);
                }
            }
        }
    }

    public function delete(string $id)
    {
        if (JWTAuth::user()->cannot('index', Book::class)) {
            return response()->json(['message' => 'Permission denied'], 403);
        } else {
            $book = Book::find($id);

            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            } else {
                $storage = Storage::disk('public');

                $storage->delete($book->cover);
                $book->delete();

                return response()->json(['message' => 'Book successfully deleted'], 200);
            }
        }
    }
}

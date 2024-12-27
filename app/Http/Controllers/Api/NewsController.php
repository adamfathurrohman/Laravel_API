<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller


{
    public function index()
{
    $news = News::all();

    return response()->json([
        'message' => 'Berhasil mengambil data berita',
        'data' => $news,
    ], 200);
}

public function show($id)
{
    $news = News::find($id);

    if (!$news) {
        return response()->json([
            'message' => 'Berita tidak ditemukan',
        ], 404);
    }

    return response()->json([
        'message' => 'Berhasil mengambil detail berita',
        'data' => $news,
    ], 200);
}

    // Tambah berita baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
        ]);

        $news = News::create($validatedData);

        return response()->json([
            'message' => 'Berita berhasil ditambahkan',
            'data' => $news,
        ], 201);
    }

    // Update berita
    public function update(Request $request, $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'image_url' => 'nullable|url',
        ]);

        $news->update($validatedData);

        return response()->json([
            'message' => 'Berita berhasil diperbarui',
            'data' => $news,
        ], 200);
    }

    // Hapus berita
    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $news->delete();

        return response()->json([
            'message' => 'Berita berhasil dihapus',
        ], 200);
    }
}

<?php

namespace App\Http\Services\Posts;

use App\Http\Requests\Posts\PostStoreRequest;
use App\Models\Posts;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class storeService
{
    static public function index(PostStoreRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $post = new Posts();

            $post->title = $request->titulo;
            $post->subtitle = $request->subtitulo;
            $post->user_id = $user->id;

            if ($request->hasFile('file')) {
                if ($post->image && Storage::exists($post->image)) {
                    Storage::delete($post->image);
                }
                $filename = 'expense_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->storeAs('posts', $filename, 'public');
                $post->image = "public/posts/" . $filename;
            }
            $post->save();

            return response()->json(["message" => 'Se ha creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Ocurrió un error inesperado al crear la noticia"
            ], 500);
        }
    }
}

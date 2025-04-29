<?php

namespace App\Http\Services\Posts;

use App\Http\Requests\Posts\PostEditRequest;
use App\Models\Posts;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class editService
{
    static public function index(PostEditRequest $request, string $id): JsonResponse
    {
        try {
            $post = Posts::where('id', $id)->first();

            if (!$post) return response()->json(["message" => "Servicio no encontrado"], 404);

            $post->title = $request->titulo;
            $post->subtitle = $request->subtitulo;

            if ($request->hasFile('file')) {
                if ($post->image && Storage::exists($post->image)) {
                    Storage::delete($post->image);
                }
                $filename = 'expense_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->storeAs('posts', $filename, 'public');
                $post->image = "public/posts/" . $filename;
            }

            $post->save();

            return response()->json(["message" => 'Se ha editado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Ocurrió un error inesperado al editar el servicio"
            ], 500);
        }
    }
}

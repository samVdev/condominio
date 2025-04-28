<?php

namespace App\Http\Services\Posts;

use App\Models\Posts;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        try {
            $post = Posts::find($id);

            if (!$post) return response()->json(['message' => 'Noticia no encontrada'], 404);

            if ($post->image && Storage::exists($post->image)) Storage::delete($post->image);

            $post->delete();

            return response()->json(['message' => 'Noticia eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error inesperado al eliminar la noticia'
            ], 500);
        }
    }
}

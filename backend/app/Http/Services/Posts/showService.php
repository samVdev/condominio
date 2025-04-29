<?php

namespace App\Http\Services\Posts;

use App\Models\Posts;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        try {
            $postDB = Posts::select('title', 'subtitle', 'image', 'personas.fullName')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('personas', 'personas.id', '=', 'users.persona_id')
            ->where('posts.id', $id)->first();

            $post = [          
                'titulo' => $postDB->title,               
                'subtitulo' => $postDB->subtitle,
                'imagen' => $postDB->image,
                'usuario' => $postDB->fullName,
            ];
    
            return response()->json($post, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}

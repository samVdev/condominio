<?php

namespace App\Http\Services\Posts;

use App\Models\Posts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class indexService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $search = $request->input("search");
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $direction = $request->input("direction");
            $sort = $request->input("sort");

            $postDB = Posts::select('posts.id', 'title', 'subtitle', 'image', 'personas.fullName')
                ->leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('personas', 'personas.id', '=', 'users.persona_id');

            if (!empty($search)) {
                $postDB->where(function ($query) use ($search) {
                    $query->where('title', 'ilike', "%{$search}%")
                        ->orWhere('subtitle', 'ilike', "%{$search}%")
                        ->orWhere('personas.fullName', 'ilike', "%{$search}%");
                });
            }

            $postDB = $postDB->skip($offset)->take($limit)->get();

            $posts = $postDB->map(function ($post) {
                return [
                    'id' => $post->id,
                    'titulo' => $post->title,
                    'subtitulo' => $post->subtitle,
                    'imagen' => $post->image,
                    'usuario' => $post->fullName,
                ];
            });

            return response()->json([
                "rows" => $posts,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}

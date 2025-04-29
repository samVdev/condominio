<?php

namespace App\Http\Services\Posts;

use App\Mail\NewsMail;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class emailService
{
    static public function index(string $id): JsonResponse
    {
        try {
            $post = Posts::select('title', 'subtitle', 'image')->where('id', $id)->first();

            if (!$post) {
                return response()->json(['message' => 'Noticia no encontrado'], 404);
            }
        
            $imagePath = Storage::path($post->image);

            $validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
            $emails = User::where(function ($query) use ($validDomains) {
                foreach ($validDomains as $domain) {
                    $query->orWhere('email', 'like', '%@' . $domain);
                }
            })->pluck('email')->toArray();

            $chunks = array_chunk($emails, 10);

            foreach ($chunks as $chunk) {
                Mail::to($chunk)->queue(new NewsMail($post->title, $post->subtitle, $post->image));
            }

            return response()->json(['message' => $imagePath], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}

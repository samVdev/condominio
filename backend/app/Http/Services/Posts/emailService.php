<?php

namespace App\Http\Services\Posts;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class EmailService
{
    static public function index(string $id) : JsonResponse
    {
        try {

        $apiUrl = env('API_NODE') . '/api/send-email';
        
        $post = Posts::select('title', 'subtitle', 'image')->where('id', $id)->first();

        if (!$post) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $imagePath = Storage::path($post->image);
        $imageContent = base64_encode(file_get_contents($imagePath));

        $validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
        $emails = User::where(function ($query) use ($validDomains) {
            foreach ($validDomains as $domain) {
                $query->orWhere('email', 'like', '%@' . $domain);
            }
        })->pluck('email')->toArray();

        $htmlContent = view('emails.news', [
            'title' => $post->title,
            'subtitle' => $post->subtitle,
            'image' => $imageContent
        ])->render();

        $response = Http::withOptions([
            'proxy' => env('HTTP_PROXY'),
        ])->withHeaders([
            'x-api-key' => env('API_KEY_NODE'),
        ])->post($apiUrl, [
            'user' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'postId' => $id,
            'html' => $htmlContent,
            'asunto' => 'Nueva publicación: ' . $post->title,
            'recipients' => $emails
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error al enviar correos',
            ], 500);
        }

        return response()->json([
            'message' => 'Correos enviados exitosamente',
            'imagePath' => $imagePath,
            'recipientsCount' => count($emails)
        ], 200);


    } catch (\Exception $e) {
        return response()->json([
            "message" => "Ocurrió un error inesperado al editar el servicio"
        ], 500);
    }
    }

    
}
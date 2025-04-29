<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $subtitle;
    public $imagePath;

    public function __construct(string $title, string $subtitle, string $image)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->imagePath = $image; 
    }

    public function build()
    {
        $imageUrl = config('app.url') . '/' . $this->imagePath;

        return $this->view('emails.news')
            ->subject('Nueva Noticia')
            ->with([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'image' => $imageUrl, 
            ]);
    }
}

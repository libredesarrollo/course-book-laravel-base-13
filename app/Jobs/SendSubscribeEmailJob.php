<?php

namespace App\Jobs;

use App\Mail\SubscribeEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendSubscribeEmailJob implements ShouldQueue
{
    use Queueable;

    public $queue = 'culeables'; // nombre de la cola php artisan queue:work --queue=culeables
    public $tries = 5; // cinco intentos

    /**
     * Create a new job instance.
     */
    // public User $user;
    // public function __construct(User $user)
    public function __construct(public User $user)
    {
       // $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to('no-reply@example.net.com')
        Mail::to($this->user->email)
             ->send(new SubscribeEmail('contact@gmail.com', 'SUPER PROMO', '<h1>VIVA LA PATRIA<h1><p>Hola loKito!</p>'));
    }
}

<?php
namespace App\Actions;

use App\Models\Todo;
use App\Models\User;
use App\Events\TodoCreated;
use Illuminate\Support\Facades\DB;

class CreateTodo
{
    /**
     * Ejecuta la lógica de negocio para crear un To-Do.
     */
    public function handle(?User $user, array $attributes)
    {
        // Encapsulamos la lógica de negocio pura
        return DB::transaction(function () use ($user, $attributes) {
            dd(true);
            // $todo = Todo::create([
            //     'user_id'     => $user->id,
            //     'description' => $attributes['description'],
            //     'status'      => 'pending',
            // ]);

            // // Disparar eventos o notificaciones del sistema
            // event(new TodoCreated($todo));

            return $todo;
        });
    }
}
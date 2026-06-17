<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\CreateTodo;
use Illuminate\Http\Request;

// use App\Http\Resources\TodoResource;

class TodoController extends Controller
{
    public function store(Request $request, CreateTodo $createTodo)
    {
        // 1. El Action procesa la lógica de negocio entrante
        $todo = $createTodo->handle(
            $request->user(), 
            $request->all()
        );

        // 2. El Resource (API Resource) se encarga de formatear la respuesta HTTP de salida
        // return new TodoResource($todo);
    }
}
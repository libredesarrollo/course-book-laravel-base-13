<?php

namespace App\Http\Controllers\Pruebas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        return view('pruebas.dashboard', [
            'user' => 'Andrés Cruz',
            'role' => 'admin',
            'status' => 2, // 1: Pendiente, 2: Activo, 3: Suspendido
            'courses' => [
                ['id' => 1, 'name' => 'Laravel 13', 'type' => 'Backend', 'premium' => true],
                ['id' => 2, 'name' => 'Vue.js 3', 'type' => 'Frontend', 'premium' => false],
                ['id' => 3, 'name' => 'AWS Cloud', 'type' => 'DevOps', 'premium' => true],
            ],
            'tags' => [], // Array vacío para probar @forelse
            'isSubscribed' => true,
        ]);
    }
}
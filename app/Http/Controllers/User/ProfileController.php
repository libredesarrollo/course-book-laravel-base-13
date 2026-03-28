<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    /**
     * Muestra el formulario de perfil.
     */
    public function edit(Request $request)
    {
        return view('auth.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validación de datos
        $validated = $request->validate([
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048', // Imagen opcional, máx 2MB
        ]);

        $profileData = [];

        if ($request->has('address')) {
            $profileData['address'] = $validated['address'];
        }

        // Manejo de subida de Avatar
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->profile && $user->profile->avatar) {
                Storage::disk('public')->delete($user->profile->avatar);
            }

            // Guardar nueva imagen en la carpeta 'avatars' del disco público
            $path = $request->file('avatar')->store('avatars', 'public');
            $profileData['avatar'] = $path;
        }

        // Actualizar o crear el registro en la tabla profiles
        // Se asume que en el modelo User existe la relación public function profile()
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return back()->with('status', 'Perfil actualizado correctamente.');
    }
}

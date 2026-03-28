<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('auth.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        $profileData = [];

        if ($request->has('address')) {
            $profileData['address'] = $validated['address'];
        }

        if ($request->hasFile('avatar')) {
            if ($user->profile?->avatar) {
                Storage::disk('public')->delete($user->profile->avatar);
            }
            $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return back()->with('status', 'Perfil actualizado correctamente.');
    }
}

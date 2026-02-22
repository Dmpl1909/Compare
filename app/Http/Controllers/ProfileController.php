<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $favorites = $user->favorites()->with(['product.offers.source'])->latest()->take(5)->get();

        return view('profile.edit', [
            'user' => $user,
            'favorites' => $favorites,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $this->normalizeAvatarPath($user->avatar);

            if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                Storage::disk('public')->delete($oldAvatarPath);
            }

            $legacyAvatar = public_path('avatars/' . basename((string) $user->avatar));
            if (is_file($legacyAvatar)) {
                @unlink($legacyAvatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('status', 'Perfil atualizado com sucesso.');
    }

    private function normalizeAvatarPath(?string $avatar): ?string
    {
        if (! $avatar) {
            return null;
        }

        $avatar = trim($avatar);

        if ($avatar === '') {
            return null;
        }

        if (str_starts_with($avatar, 'avatars/')) {
            return $avatar;
        }

        if (str_contains($avatar, '/')) {
            return ltrim($avatar, '/');
        }

        return 'avatars/' . $avatar;
    }
}

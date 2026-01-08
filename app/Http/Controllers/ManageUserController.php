<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ManageUserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        
        return view('manage.users.index', [
            'users' => $users,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Only admins can change user roles
        if ($request->user()->role !== 'admin') {
            return back()->with('error', 'Apenas administradores podem alterar permissões.');
        }

        $validated = $request->validate([
            'role' => ['required', Rule::in(['cliente', 'gestor', 'admin'])],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return back()->with('status', "Permissão de {$user->name} alterada para {$user->role}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Não podes eliminar a tua própria conta.');
        }

        $user->delete();

        return back()->with('status', 'Utilizador eliminado com sucesso.');
    }
}

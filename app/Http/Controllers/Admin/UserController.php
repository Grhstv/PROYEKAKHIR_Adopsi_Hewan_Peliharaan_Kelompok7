<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pengguna.index', [
            'users' => User::with('roles')->orderBy('name')->get(),
            'roles' => Role::whereIn('name', ['admin', 'petugas', 'adopter'])->orderBy('name')->pluck('name'),
        ]);
    }

    /** Role hanya dapat diubah di sini (butuh izin 'kelola pengguna'). */
    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'petugas', 'adopter'])],
        ]);

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $otherRoles = $user->getRoleNames()
            ->reject(fn (string $role): bool => in_array($role, ['admin', 'petugas', 'adopter'], true))
            ->all();
        $user->syncRoles([...$otherRoles, $data['role']]);

        return back()->with('success', "Role {$user->name} diubah menjadi {$data['role']}.");
    }
}

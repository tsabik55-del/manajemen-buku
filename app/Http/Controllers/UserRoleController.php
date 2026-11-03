<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Display a listing of users and their roles.
     */
    public function index(): View
    {
        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::orderBy('name')->pluck('name');

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Update the role of the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', "Role {$user->name} berhasil diperbarui.");
    }
}

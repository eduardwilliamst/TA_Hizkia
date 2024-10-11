<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return view('roles.index', compact('users', 'roles'));
    }

    public function editRole(User $user)
    {
        $roles = Role::all();
        return view('roles.editRole', compact('user', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->syncRoles([$role->id]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }
}

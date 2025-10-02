<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
    $users = User::with('watchlist')->get();
    return view('admin.index', compact('users'));
    }

    public function edit(User $user)
    {
        Gate::authorize('update-user', $user);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update-user', $user);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:user,admin,super admin',
        ]);
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công!');
    }
}

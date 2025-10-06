<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    // lấy danh sách user . Truyền sang view
    public function index()
    {
        $users = User::with('watchlist')->get();
        return view('superadmin.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize('create-user');
        return view('superadmin.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create-user');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,admin,superadmin',
        ]);
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect()->route('superadmin.users.index')->with('success', 'Tạo user thành công!');
    }

    public function edit(User $user)
    {
        Gate::authorize('update-user', $user);
        return view('superadmin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update-user', $user);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin,superadmin',
        ]);
        $user->update($data);
        return redirect()->route('superadmin.users.index')->with('success', 'Cập nhật user thành công!');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete-user', $user);
        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'Xóa user thành công!');
    }
}

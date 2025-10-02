@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 py-8">
    <div class="w-full max-w-lg bg-white bg-opacity-90 rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">Sửa User</h2>
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2" required>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <!-- <option value="super admin" {{ $user->role == 'super admin' ? 'selected' : '' }}>Super Admin</option> -->
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 py-8">
    <div class="w-full max-w-md bg-white bg-opacity-90 rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">Tạo User mới</h2>
        <form method="POST" action="{{ route('superadmin.users.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Tên</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2 mt-1" value="{{ old('name') }}" required>
                @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2 mt-1" value="{{ old('email') }}" required>
                @error('email')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Mật khẩu</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 mt-1" required>
                @error('password')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
                @error('role')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 transition">Tạo mới</button>
            </div>
        </form>
    </div>
</div>
@endsection

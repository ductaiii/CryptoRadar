@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 py-8">
    <div class="w-4/5 max-w-6xl bg-white bg-opacity-90 rounded-2xl shadow-xl p-8">
        <div class="mb-6 text-gray-700">Super Admin {{ auth()->user()->name }}</div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-700">Quản lý User (Super Admin)</h2>
            <a href="{{ route('superadmin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 transition">Thêm User</a>
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-700">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white rounded-2xl shadow overflow-hidden">
            <thead>
                <tr class="bg-gradient-to-r from-blue-100 to-purple-100">
                    <th class="py-3 px-4 font-semibold text-gray-700 text-center rounded-tl-2xl">ID</th>
                    <th class="py-3 px-4 font-semibold text-gray-700 text-center">Tên</th>
                    <th class="py-3 px-4 font-semibold text-gray-700 text-center">Email</th>
                    <th class="py-3 px-4 font-semibold text-gray-700 text-center">Role</th>
                    <th class="py-3 px-4 font-semibold text-gray-700 text-center">Watchlist</th>
                    <th class="py-3 px-4 font-semibold text-gray-700 text-center rounded-tr-2xl">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="text-center hover:bg-blue-50 transition">
                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b capitalize">{{ $user->role }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($user->watchlist->count())
                            <ul class="text-left list-none pl-0">
                                @foreach($user->watchlist as $item)
                                    <li class="mb-1">{{ $item->coin_name }} <span class="text-xs text-gray-400">({{ $item->coin_symbol }})</span></li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-400 italic">Không có</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('superadmin.users.edit', $user) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Bạn chắc chắn muốn xóa user này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

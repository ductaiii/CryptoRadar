<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// sử dụng user fix lỗi auth()->user() báo lỗi undefined method user


class WatchlistController extends Controller
{// Trả về mảng coin_id user đã lưu

    public function json(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();
        return $user->watchlist()
            ->pluck('coin_id')
            ->toArray();
    }

    // Lưu 1 item (tránh trùng)
    public function store(Request $request)
    {
        $data = $request->validate([
            'coin_id'     => 'required|string',
            'coin_symbol' => 'required|string',
            'coin_name'   => 'required|string',
            'coin_image'  => 'required|url',
        ]);

        /** @var User $user */
        $user = $request->user();
        if ($user) {
            $exists = $user->watchlist()
                ->where('coin_id', $data['coin_id'])
                ->exists();

            if (! $exists) {
                $user->watchlist()->create($data);
            }
        }

        return response()->json(['ok' => true]);
    }

    // Xoá theo coin_id (đỡ phải biết row id)
    public function destroyByCoin(Request $request, string $coinId)
    {
        /** @var User $user */
        $user = $request->user();
        $item = $user->watchlist()
            ->where('coin_id', $coinId)
            ->firstOrFail();

        $item->delete();

        return response()->json(['ok' => true]);
    }
}

<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">My Watchlist</h1>

        <ul>
            @foreach($watchlist as $item)
                <li class="flex items-center mb-2">
                    <img src="{{ $item->coin_image }}" class="w-6 h-6 mr-2">
                    {{ $item->coin_name }} ({{ strtoupper($item->coin_symbol) }})
                    <form method="POST" action="{{ route('watchlist.destroy', $item->id) }}" class="ml-2">
                        @csrf @method('DELETE')
                        <button class="text-red-500">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>

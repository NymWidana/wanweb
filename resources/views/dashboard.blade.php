<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900 dark:text-gray-100">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded">
                {{ session('error') }}
            </div>
        @endif

        <h3 class="text-lg font-bold mb-4">Available Services</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($templates as $template)
                <div class="border dark:border-gray-700 p-4 rounded shadow-sm bg-white dark:bg-gray-800">
                    @if($template->image)
                        <img src="{{ asset('storage/' . $template->image) }}" alt="{{ $template->name }}" class="w-full h-48 object-cover rounded-md mb-4">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 rounded-md mb-4 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    <h4 class="font-bold text-xl text-gray-900 dark:text-white">{{ $template->name }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 my-2">{{ $template->description }}</p>
                    <p class="text-indigo-600 dark:text-indigo-400 font-bold">${{ $template->price }}</p>

                    <form action="/order/{{ $template->id }}" method="POST" class="mt-4">
                        @csrf
                        <textarea name="notes" placeholder="Custom requirements..."
                            class="w-full mt-2 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm focus:ring-indigo-500"></textarea>
                        <button type="submit" class="w-full mt-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                            Order Now
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <hr class="my-8 border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-bold px-4 mb-4 text-gray-900 dark:text-gray-100">My Recent Orders</h3>
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-900">
                        <th class="py-3 px-4 border-b dark:border-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Website Type</th>
                        <th class="py-3 px-4 border-b dark:border-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 border-b dark:border-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Website Link</th>
                        <th class="py-3 px-4 border-b dark:border-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ordered On</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse(auth()->user()->orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="py-4 px-4 text-sm text-gray-900 dark:text-gray-200 font-medium">
                                {{ $order->template->name }}
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $progress = [
                                        'pending' => '25%',
                                        'processing' => '60%',
                                        'completed' => '100%',
                                        'cancelled' => '0%'
                                    ];
                                    $width = $progress[$order->status] ?? '0%';
                                    $barColor = $order->status == 'cancelled' ? 'bg-red-500' : 'bg-indigo-600';
                                @endphp

                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mb-1">
                                    <div class="{{ $barColor }} h-1.5 rounded-full" style="width: {{ $width }}"></div>
                                </div>
                                <span class="text-[10px] uppercase font-bold text-gray-500 dark:text-gray-400">
                                    {{ $order->status }} ({{ $width }})
                                </span>
                            </td>
                            <td class="p-4">
                                @if($order->status == 'completed' && $order->delivery_link)
                                    <a href="{{ $order->delivery_link }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Access My Website
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-xs">Awaiting completion...</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                You haven't ordered anything yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-12 p-8 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50 text-center">
        <h3 class="text-xl font-bold text-indigo-900 dark:text-indigo-300">Need something totally unique?</h3>
        <p class="text-indigo-700 dark:text-indigo-400 mt-2 mb-6">
            Can't find a template that fits? Send us your project details and we'll build it from scratch.
        </p>
        <a href="#"
        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Email Support Now
        </a>
    </div>
</x-app-layout>

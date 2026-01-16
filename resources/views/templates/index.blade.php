<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Website Services') }}
            </h2>
            <a href="{{ route('templates.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm">
                + Add New Service
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm uppercase">
                                <th class="p-4 border-b dark:border-gray-600">Preview</th>
                                <th class="p-4 border-b dark:border-gray-600">Service Name</th>
                                <th class="p-4 border-b dark:border-gray-600">Type</th>
                                <th class="p-4 border-b dark:border-gray-600">Price</th>
                                <th class="p-4 border-b dark:border-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @forelse($templates as $template)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                    <td class="p-4 w-24">
                                        @if($template->image)
                                            <img src="{{ asset('storage/' . $template->image) }}" class="w-16 h-12 object-cover rounded shadow-sm border dark:border-gray-600">
                                        @else
                                            <div class="w-16 h-12 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-[10px] text-gray-400">
                                                No Image
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $template->name }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($template->description, 50) }}</div>
                                    </td>

                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $template->type == 'custom' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                            {{ $template->type }}
                                        </span>
                                    </td>

                                    <td class="p-4 font-mono font-bold text-indigo-600 dark:text-indigo-400">
                                        ${{ number_format($template->price, 2) }}
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('templates.edit', $template) }}" class="text-gray-500 hover:text-indigo-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <form action="{{ route('templates.destroy', $template) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-500 italic">
                                        No services found. Click "Add New Service" to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

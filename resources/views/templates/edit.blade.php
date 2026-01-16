<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Service:') }} {{ $template->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('templates.update', $template) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-8 shadow rounded-lg border dark:border-gray-700">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block dark:text-gray-300 font-bold mb-2">Service Name</label>
                    <input type="text" name="name" value="{{ old('name', $template->name) }}"
                           class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block dark:text-gray-300 font-bold mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('description', $template->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block dark:text-gray-300 font-bold mb-2">Price ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $template->price) }}"
                               class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block dark:text-gray-300 font-bold mb-2">Category</label>
                        <select name="type" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="template" {{ $template->type == 'template' ? 'selected' : '' }}>Template Site</option>
                            <option value="custom" {{ $template->type == 'custom' ? 'selected' : '' }}>Custom Build</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block dark:text-gray-300 font-bold mb-2">Update Thumbnail</label>

                    @if($template->image)
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-1">Current Image:</p>
                            <img src="{{ asset('storage/' . $template->image) }}" class="w-32 h-20 object-cover rounded border dark:border-gray-600">
                        </div>
                    @endif

                    <input type="file" name="image" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-gray-400 italic">Leave empty to keep the current image.</p>
                </div>

                <div class="flex items-center justify-between border-t dark:border-gray-700 pt-6">
                    <a href="{{ route('templates.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline text-sm">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Update Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

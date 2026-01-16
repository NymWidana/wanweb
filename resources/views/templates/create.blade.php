<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-8 shadow rounded-lg border dark:border-gray-700">
                @csrf

                <div class="mb-4">
                    <label class="block dark:text-gray-300 font-bold mb-2">Service Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g., E-commerce Starter"
                           class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block dark:text-gray-300 font-bold mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Describe what the customer gets..."
                              class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block dark:text-gray-300 font-bold mb-2">Price ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="99.99"
                               class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block dark:text-gray-300 font-bold mb-2">Category</label>
                        <select name="type" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="template" {{ old('type') == 'template' ? 'selected' : '' }}>Template Site</option>
                            <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>Custom Build</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block dark:text-gray-300 font-bold mb-2">Service Thumbnail</label>
                    <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md hover:border-indigo-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 00-4 4H12a4 4 0 00-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="file-upload" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="image" type="file" class="sr-only">
                                </label>
                                <p id="status-text" class="pl-1 text-gray-600 dark:text-gray-400">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between border-t dark:border-gray-700 pt-6">
                    <a href="{{ route('templates.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline text-sm">Back to List</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-8 rounded-lg shadow-lg transition duration-200 transform hover:scale-105">
                        Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('file-upload').onchange = function() {
            if(this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const uploadText = this.parentElement.parentElement.querySelector('p');
                uploadText.innerHTML = "Selected: <span class='text-indigo-600 font-bold'>" + fileName + "</span>";
            }
        };

        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-upload');
        const statusText = dropZone.querySelector('p.text-gray-600');

        // Prevent default behaviors (preventing browser from opening the file)
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/10');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/10');
            }, false);
        });

        // Handle dropped files
        dropZone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files; // Assign the dropped file to the hidden input
                updateStatusText(files[0].name);
            }
        });

        // Handle click to select
        dropZone.addEventListener('click', () => fileInput.click());

        // Update text when file is chosen (via drop or click)
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                updateStatusText(fileInput.files[0].name);
            }
        });

        function updateStatusText(name) {
            statusText.innerHTML = "Selected: <span class='text-indigo-600 font-bold'>" + name + "</span>";
        }
    </script>
</x-app-layout>

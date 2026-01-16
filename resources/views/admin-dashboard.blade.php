<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6  rounded-lg shadow border border-green-100 dark:border-green-900/30">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-blue-100 dark:border-blue-900/30">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Workload</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeOrders }} Orders</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-purple-100 dark:border-purple-900/30">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Clients</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700 h-[350px] sm:mx-6 lg:mx-8">
            <h3 class="text-sm font-bold mb-4 dark:text-gray-400 uppercase tracking-widest">Revenue Growth (Monthly)</h3>
            <div class="h-[250px]">
                <canvas id="growthChart"></canvas>
            </div>
        </div>
        <div class=" mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 sm:px-6 lg:px-8">
            {{-- Revenue Chart --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700 h-[350px]">
                <h3 class="text-sm font-bold mb-4 dark:text-gray-400 uppercase tracking-widest">Revenue by Product ($)</h3>
                <div class="h-[250px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Status Chart --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700 h-[350px]">
                <h3 class="text-sm font-bold mb-4 dark:text-gray-400 uppercase tracking-widest">Order Statuses</h3>
                <div class="h-[250px]">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                    {{ __('Customer Orders') }}
                </h3>

                {{-- searh and filter --}}
                <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow border dark:border-gray-700">
                    <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by customer name or email..."
                                class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500">
                        </div>

                        <div class="w-full md:w-48">
                            <select name="status" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded font-bold transition">
                                Filter
                            </button>
                            <a href="{{ route('admin.orders') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded text-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm uppercase">
                    <th class="p-4 border-b dark:border-gray-600">Customer</th>
                    <th class="p-4 border-b dark:border-gray-600">Service</th>
                    <th class="p-4 border-b dark:border-gray-600 text-center">Status</th>
                    <th class="p-4 border-b dark:border-gray-600 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-gray-700">
                @forelse($allOrders as $order)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                        </td>

                        <td class="p-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $order->template->name }}</div>
                            <div class="text-xs text-indigo-600 dark:text-indigo-400 font-bold">${{ number_format($order->template->price, 2) }}</div>
                        </td>

                        <td class="p-4 text-center">
                            @php
                                $colors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                $badgeClass = $colors[$order->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-end gap-4">
                                <button
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'order-details-{{ $order->id }}')"
                                    class="text-gray-400 hover:text-indigo-600 transition cursor-pointer"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>

                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    @method('PATCH')

                                    <div class="flex items-center gap-2">
                                        <select name="status" class="text-xs rounded border-gray-300 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>

                                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded text-xs font-bold">Update</button>
                                    </div>

                                    <input type="text" name="delivery_link" value="{{ $order->delivery_link }}"
                                        placeholder="Paste site link here..."
                                        class="w-full text-[10px] rounded border-gray-300 dark:bg-gray-900 dark:text-gray-300 p-1">
                                </form>
                            </div>
                        </td>
                    </tr>

                    <x-modal name="order-details-{{ $order->id }}" focusable>
                        <div class="p-6">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">
                                Detailed Request View #{{ $order->id }}
                            </h2>
                            <div class="grid grid-cols-2 gap-6 text-sm">
                                <div>
                                    <label class="text-gray-400 block mb-1">Customer Details</label>
                                    <p class="font-bold dark:text-white">{{ $order->user->name }}</p>
                                    <p class="dark:text-gray-300">{{ $order->user->email }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-400 block mb-1">Submission Date</label>
                                    <p class="font-bold dark:text-white">{{ $order->created_at->format('D, M j, Y') }}</p>
                                    <p class="dark:text-gray-300">{{ $order->created_at->format('g:i A') }}</p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <label class="text-gray-400 block mb-1 uppercase text-xs font-bold tracking-tighter">Project Description & Notes</label>
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border dark:border-gray-700 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">
                                    {{ $order->notes ?: 'No specific instructions provided by the client.' }}
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">Close Window</x-secondary-button>
                            </div>
                        </div>
                    </x-modal>

                @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-500 italic">
                            No orders matching your criteria were found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 bg-gray-50 dark:bg-gray-800 border-t dark:border-gray-700">
        {{ $allOrders->appends(request()->query())->links() }}
    </div>            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false, // This is the secret fix!
            plugins: {
                legend: {
                    display: false // Hides unnecessary labels for the bar chart
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)' // Light grid lines for dark mode
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        };

        // Revenue Bar Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($values) !!},
                    backgroundColor: '#6366f1',
                    borderRadius: 5
                }]
            },
            options: chartOptions
        });

        // Status Doughnut Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusLabels) !!},
                datasets: [{
                    data: {!! json_encode($statusValues) !!},
                    backgroundColor: ['#fbbf24', '#3b82f6', '#10b981', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#9ca3af',
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Monthly Sales',
                    data: {!! json_encode($monthValues) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: chartOptions
        });
    </script>
</x-app-layout>

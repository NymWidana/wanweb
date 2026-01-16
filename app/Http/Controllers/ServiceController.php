<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Template;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index() {
        // Customers only need to see templates and THEIR OWN orders
        return view('dashboard', [
            'templates' => Template::all(),
            'myOrders' => auth()->user()->orders()->with('template')->latest()->get()
        ]);
    }

    public function store(Request $request, $id)
    {
        // 1. Create the order in the database
        Order::create([
            'user_id' => auth()->id(),
            'template_id' => $id,
            'status' => 'pending',
            'notes' => $request->notes, // Add this line
        ]);

        // 2. Send them back with a success message
        return redirect()->back()->with('success', 'Thank you! Your order has been placed.');
    }

    public function adminIndex(Request $request)
    {
        // 1. Start the Query
        $query = Order::with(['user', 'template']);

        // 2. Apply Search Filter (Customer Name or Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Get Paginated Results (10 per page)
        // We use paginate() instead of get()
        $allOrders = $query->latest()->paginate(10);

        // 5. Calculate KPI Stats (These ignore pagination to show totals)
        $totalRevenue = Order::where('status', 'completed')
            ->join('templates', 'orders.template_id', '=', 'templates.id')
            ->sum('templates.price');

        $activeOrders = Order::whereIn('status', ['pending', 'processing'])->count();

        // 6. Chart Data Logic
        $stats = Template::withCount('orders')->get();
        $labels = $stats->pluck('name');
        $values = $stats->map(fn($t) => $t->orders_count * $t->price);

        $statusCounts = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $monthlyData = \App\Models\Order::where('status', 'completed')
            ->join('templates', 'orders.template_id', '=', 'templates.id')
            ->selectRaw("
                SUM(templates.price) as total,
                DATE_FORMAT(orders.created_at, '%b') as month,
                DATE_FORMAT(orders.created_at, '%Y-%m') as sort_date
            ")
            ->groupBy('month', 'sort_date') // Group by both to satisfy SQL strict mode
            ->orderBy('sort_date', 'asc')
            ->take(6)
            ->get();

        // 7. Return View with all variables
        return view('admin-dashboard', [
            'allOrders' => $allOrders,
            'totalRevenue' => $totalRevenue,
            'activeOrders' => $activeOrders,
            'labels' => $labels,
            'values' => $values,
            'statusLabels' => $statusCounts->keys(),
            'statusValues' => $statusCounts->values(),
            'monthLabels' => $monthlyData->pluck('month'),
            'monthValues' => $monthlyData->pluck('total'),
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'delivery_link' => 'nullable|url' // Ensures it's a valid link
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->delivery_link = $request->delivery_link;
        $order->save();

        return redirect()->back()->with('success', 'Order updated successfully!');
    }
}

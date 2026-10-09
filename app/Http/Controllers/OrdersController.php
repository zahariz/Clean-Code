<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DiscountService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        // 🚀 1. Eager Loading + Pagination (Mengurangi query & mencegah Memory Exhausted)
        $orders = Order::with(['user', 'items'])
            ->latest()
            ->paginate(500);

        // 🚀 2. Transformasi data per halaman secara efisien
        $orders->getCollection()->transform(function (Order $order) use ($request) {
            $discount = DiscountService::calculate($order->total_amount, $request->query('promo'));

            return [
                'id' => $order->id,
                'customer' => $order->user->name ?? 'Guest',
                'items_count' => $order->items->count(),
                'total' => $order->total_amount - $discount,
                'badge' => $order->status_badge,
                'created_at' => $order->created_at->format('d M Y H:i'),
            ];
        });

        return view('orders.index', [
            'orders' => $orders,
            'd' => $orders, // Aliasing agar kompatibel dengan Blade
        ]);
    }
}

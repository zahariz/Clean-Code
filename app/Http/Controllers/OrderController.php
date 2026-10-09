<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $req)
    {
        // ❌ N+1 PROBLEM 1: Mengambil semua order tanpa Eager Loading (without 'with')
        // ❌ BAD CODE 2: Nama variabel ambigu ($x, $o, $res)
        $x = Order::all();
        $res = [];

        foreach ($x as $o) {
            // ❌ N+1 PROBLEM 2: Memanggil relasi user di dalam loop (1 query per order!)
            $uName = $o->user ? $o->user->name : 'Guest';

            // ❌ N+1 PROBLEM 3: Memanggil relasi items di dalam loop (1 query per order!)
            $itemCount = $o->items->count();

            // ❌ BAD CODE 4: Nested If-Else Pyramid & Magic Numbers (1, 2, PAID)
            $stBadge = '';
            if ($o->status == 1) {
                if ($o->payment_status == 'PAID') {
                    if ($o->total_amount > 2000000) {
                        $stBadge = '<span class="px-2 py-1 bg-yellow-500 text-white rounded text-xs font-bold">VIP Paid</span>';
                    } else {
                        $stBadge = '<span class="px-2 py-1 bg-green-500 text-white rounded text-xs font-bold">Paid</span>';
                    }
                } else {
                    $stBadge = '<span class="px-2 py-1 bg-orange-500 text-white rounded text-xs font-bold">Waiting Payment</span>';
                }
            } else {
                if ($o->status == 2) {
                    $stBadge = '<span class="px-2 py-1 bg-blue-500 text-white rounded text-xs font-bold">Processing</span>';
                } else {
                    $stBadge = '<span class="px-2 py-1 bg-red-500 text-white rounded text-xs font-bold">Cancelled</span>';
                }
            }

            // ❌ BAD CODE 5: Logika kalkulasi diskon dimasukkan langsung ke Controller (Fat Controller)
            $discount = 0;
            if ($req->has('promo') && $req->promo == 'FLASHSALE') {
                if ($o->total_amount >= 1000000) {
                    $discount = $o->total_amount * 0.2;
                } else {
                    $discount = $o->total_amount * 0.1;
                }
            }

            $res[] = [
                'id' => $o->id,
                'customer' => $uName,
                'items_count' => $itemCount,
                'total' => $o->total_amount - $discount,
                'badge' => $stBadge,
                'created_at' => $o->created_at->format('d M Y H:i'),
            ];
        }

        return view('orders.index', ['d' => $res]);
    }
}

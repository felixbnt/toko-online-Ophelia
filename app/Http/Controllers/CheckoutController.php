<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $ongkir     = 20000;
        $grandTotal = $subtotal + $ongkir;

        return view('checkout', compact('cart', 'subtotal', 'ongkir', 'grandTotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $ongkir     = 20000;
        $grandTotal = $subtotal + $ongkir;

        // Simpan order
        $order = Order::create([
            'user_id'        => Auth::id(),
            'order_number'   => 'OPH-' . date('Y') . '-' . strtoupper(Str::random(6)),
            'payment_method' => $request->payment_method,
            'subtotal'       => $subtotal,
            'ongkir'         => $ongkir,
            'grand_total'    => $grandTotal,
            'status'         => 'pending',
        ]);

        // Simpan order items ← BARU
        foreach ($cart as $item) {
            $order->items()->create([
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'quantity'     => $item['qty'],
                'price'        => $item['price'],
            ]);
        }

        session(['last_order' => [
            'order_number'   => $order->order_number,
            'payment_method' => $order->payment_method,
            'cart'           => $cart,
            'subtotal'       => $subtotal,
            'ongkir'         => $ongkir,
            'grand_total'    => $grandTotal,
        ]]);

        session()->forget('cart');

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        $order = session('last_order');

        if (!$order) {
            return redirect()->route('home');
        }

        return view('checkout-success', compact('order'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            $subtotal += $item['price'] * $item['qty']; // FIX: pakai 'qty' bukan 'quantity'
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
            $subtotal += $item['price'] * $item['qty']; // FIX: pakai 'qty' bukan 'quantity'
        }

        $ongkir     = 20000;
        $grandTotal = $subtotal + $ongkir;

        session([
            'last_order' => [
                'order_number'   => 'OPH-' . date('Y') . '-' . strtoupper(Str::random(6)),
                'payment_method' => $request->payment_method,
                'phone_number'   => $request->phone_number ?? null,
                'cart'           => $cart,
                'subtotal'       => $subtotal,
                'ongkir'         => $ongkir,
                'grand_total'    => $grandTotal,
            ]
        ]);

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

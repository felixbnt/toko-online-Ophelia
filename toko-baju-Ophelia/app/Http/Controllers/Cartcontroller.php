<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id'       => 'required',
            'category'         => 'required',
            'name'             => 'required',
            'price'            => 'required|numeric',
            'img'              => 'required',
            'color'            => 'required',
            'size'             => 'required',
            'qty'              => 'required|integer|min:1',
            'redirect_to_cart' => 'nullable',
        ]);

        $cart = session()->get('cart', []);

        $key = $request->product_id . '_' . $request->category . '_' . $request->color . '_' . $request->size;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += (int) $request->qty;
        } else {
            $cart[$key] = [
                'id'       => $request->product_id,
                'category' => $request->category,
                'name'     => $request->name,
                'price'    => (int) $request->price,
                'img'      => $request->img,
                'color'    => $request->color,
                'size'     => $request->size,
                'qty'      => (int) $request->qty,
            ];
        }

        session()->put('cart', $cart);

        if ($request->redirect_to_cart == '1') {
            return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $qty = (int) $request->qty;
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty']   = $qty;
                $cart[$id]['color'] = $request->color ?? $cart[$id]['color'];
                $cart[$id]['size']  = $request->size  ?? $cart[$id]['size'];
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang');
    }

    public function batchRemove(Request $request)
    {
        $cart = session()->get('cart', []);
        $keys = $request->input('keys', []);

        foreach ($keys as $key) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', count($keys) . ' produk berhasil dihapus dari keranjang');
    }
}

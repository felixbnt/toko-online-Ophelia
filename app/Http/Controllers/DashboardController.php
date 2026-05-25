<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
    $user         = Auth::user();
    $pesanan      = Order::where('user_id', $user->id)->latest()->get();
    $jumlahPesanan = $pesanan->count();

    return view('dashboard', compact('pesanan', 'jumlahPesanan'));
    }
}
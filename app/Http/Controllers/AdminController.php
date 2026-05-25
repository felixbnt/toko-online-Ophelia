<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $totalProducts = DB::table('products')->count();
        $totalOrders   = Order::count();
        $totalUsers    = DB::table('users')->where('role', 'user')->count();
        $totalRevenue  = Order::where('status', 'completed')->sum('grand_total');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($o) => [
                'id'     => $o->id,
                'name'   => $o->user->name ?? 'Pelanggan',
                'total'  => $o->grand_total,
                'status' => $o->status,
            ]);

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalOrders'   => $totalOrders,
            'totalUsers'    => $totalUsers,
            'totalRevenue'  => $totalRevenue,
            'recentOrders'  => $recentOrders,
            'topProducts'   => null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA PRODUK
    |--------------------------------------------------------------------------
    */
    public function products()
    {
        $products = DB::table('products')->get();
        return view('admin.products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
            'stok'     => 'required|integer|min:0',
            'category' => 'required|in:man,woman,kids',
        ]);

        DB::table('products')->insert([
            'name'       => $request->nama,
            'price'      => $request->harga,
            'stock'      => $request->stok,
            'category'   => $request->category,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
            'stok'     => 'required|integer|min:0',
            'category' => 'required|in:man,woman,kids',
        ]);

        DB::table('products')->where('id', $id)->update([
            'name'       => $request->nama,
            'price'      => $request->harga,
            'stock'      => $request->stok,
            'category'   => $request->category,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | PESANAN (ORDERS)
    |--------------------------------------------------------------------------
    */
    public function orders()
    {
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders', [
            'orders'           => $orders,
            'totalOrders'      => $orders->count(),
            'pendingOrders'    => $orders->where('status', 'pending')->count(),
            'processingOrders' => $orders->where('status', 'processing')->count(),
            'completedOrders'  => $orders->where('status', 'completed')->count(),
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        // ✅ Simpan ke database
        Order::where('id', $id)->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN (REPORTS)
    |--------------------------------------------------------------------------
    */
    public function reports(Request $request)
    {
        $period      = (int) $request->get('period', 30);
        $totalRevenue  = Order::where('status', 'completed')->sum('grand_total');
        $totalOrders   = Order::count();
        $totalCustomers = DB::table('users')->where('role', 'user')->count();
        $avgOrderValue  = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $salesData      = array_map(fn() => rand(200000, 1500000), range(0, 29));

        return view('admin.reports', [
            'period'         => $period,
            'totalRevenue'   => $totalRevenue,
            'totalOrders'    => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'avgOrderValue'  => $avgOrderValue,
            'manPct'         => 45,
            'womanPct'       => 38,
            'kidsPct'        => 17,
            'salesData'      => $salesData,
            'topProducts'    => null,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $totalOrders   = 0;   // aktifkan setelah tabel orders ada
        $totalUsers    = DB::table('users')->where('role', 'user')->count();
        $totalRevenue  = 0;   // aktifkan setelah tabel orders ada

        // TODO: aktifkan setelah ada tabel orders
        // $totalOrders  = DB::table('orders')->count();
        // $totalRevenue = DB::table('orders')->where('status','completed')->sum('total');
        // $recentOrders = DB::table('orders')
        //                   ->join('users','orders.user_id','=','users.id')
        //                   ->select('orders.*','users.name as name')
        //                   ->latest('orders.created_at')->take(5)->get()
        //                   ->map(fn($o) => [
        //                       'id'     => $o->id,
        //                       'name'   => $o->name,
        //                       'total'  => $o->total,
        //                       'status' => $o->status,
        //                   ]);

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalOrders'   => $totalOrders,
            'totalUsers'    => $totalUsers,
            'totalRevenue'  => $totalRevenue,
            'recentOrders'  => null,   // null → blade pakai demo data bawaan
            'topProducts'   => null,   // null → blade pakai demo data bawaan
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

    // CREATE
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

    // UPDATE
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

    // DELETE
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
        return view('admin.orders', [
            'orders'           => collect([]),
            'totalOrders'      => 0,
            'pendingOrders'    => 0,
            'processingOrders' => 0,
            'completedOrders'  => 0,
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        return response()->json(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN (REPORTS)
    |--------------------------------------------------------------------------
    */
    public function reports(Request $request)
    {
        $period    = (int) $request->get('period', 30);
        $salesData = array_map(fn() => rand(200000, 1500000), range(0, 29));

        return view('admin.reports', [
            'period'         => $period,
            'totalRevenue'   => 4093000,
            'totalOrders'    => 24,
            'totalCustomers' => 18,
            'avgOrderValue'  => 170542,
            'manPct'         => 45,
            'womanPct'       => 38,
            'kidsPct'        => 17,
            'salesData'      => $salesData,
            'topProducts'    => null,
        ]);
    }
}
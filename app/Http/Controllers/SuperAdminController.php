<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA ADMIN
    |--------------------------------------------------------------------------
    */
    public function admins()
    {
        $admins = User::where('role', 'admin')->get();
        return view('superadmin.admins', compact('admins'));
    }

        public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
            'status'   => $request->status,
        ]);

        return redirect()->route('superadmin.admins')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $id,
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $admin->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $admin->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('superadmin.admins')->with('success', 'Admin berhasil diupdate.');
    }

    public function destroyAdmin($id)
    {
        User::where('id', $id)->where('role', 'admin')->delete();
        return redirect()->route('superadmin.admins')->with('success', 'Admin berhasil dihapus.');
    }

    /*
|--------------------------------------------------------------------------
| KELOLA USER
|--------------------------------------------------------------------------
*/
public function users()
{
    $users = User::where('role', 'user')->get();
    return view('superadmin.users', compact('users'));
}

public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|unique:users,email,' . $id,
        'status' => 'required|in:aktif,nonaktif',
    ]);

    $user->update([
        'name'   => $request->name,
        'email'  => $request->email,
        'status' => $request->status,
    ]);

    return redirect()->route('superadmin.users')->with('success', 'User berhasil diupdate.');
}

public function destroyUser($id)
{
    User::where('id', $id)->where('role', 'user')->delete();
    return redirect()->route('superadmin.users')->with('success', 'User berhasil dihapus.');
}

    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAINNYA
    |--------------------------------------------------------------------------
    */
    public function transactions()
    {
    $orders = \App\Models\Order::with(['user', 'items'])->latest()->get();
    $totalTransaksi  = $orders->count();
    $totalPendapatan = $orders->where('status', 'completed')->sum('grand_total');
    $totalPending    = $orders->where('status', 'pending')->count();
    $totalSelesai    = $orders->where('status', 'completed')->count();

    return view('superadmin.transactions', compact(
        'orders',
        'totalTransaksi',
        'totalPendapatan',
        'totalPending',
        'totalSelesai'
    ));
    }

    public function systems()
    {
        return view('superadmin.systems');
    }

    public function reports()
    {
        return view('superadmin.reports');
    }

    public function auditlog()
    {
        return view('superadmin.auditlog');
    }
}
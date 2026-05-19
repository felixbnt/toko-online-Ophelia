<?php

namespace App\Http\Controllers;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function admins()
    {
        return view('superadmin.admins');
    }

    public function users()
    {
        return view('superadmin.users');
    }

    public function transactions()
    {
        return view('superadmin.transactions');
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

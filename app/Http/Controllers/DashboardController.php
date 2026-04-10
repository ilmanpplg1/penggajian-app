<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Departemen;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan   = Karyawan::count();
        $totalJabatan    = Jabatan::count();
        $totalDepartemen = Departemen::count();

        return view('dashboard', compact('totalKaryawan', 'totalJabatan', 'totalDepartemen'));
    }
}

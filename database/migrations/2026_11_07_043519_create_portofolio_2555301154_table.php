<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PortofolioController extends Controller
{
    public function index()
    {
        $portofolios = DB::table('Portofolio_2555301154')->get();

        return view('portofolio.index', compact('portofolios'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // return redirect('dashboard');
        if(auth()->user()->role == 1) return redirect('berita-aggregator/grafik'); //admin, dashboard->with(['success'=>'You are logged in.'])
        else return redirect('berita/semua'); //penggemar//penjual
    }
}

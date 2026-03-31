<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Movie extends Controller
{
    public function theloai()
    {
        $phim = DB::table('genre as g')
            ->select('g.*')
            ->get();
        
        return view('theloai', compact('phim'));
    }
}
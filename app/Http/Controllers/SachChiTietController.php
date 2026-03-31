<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class SachChiTietController extends Controller
{

    public function chitiet($id)
    {
        $book = DB::select("select * from sach where id = ?", [$id]);
        $data = $book[0];    
        return view("sach.chitiet", compact("data"));
    }

}
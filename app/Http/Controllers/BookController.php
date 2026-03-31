<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    function sach()
    {
        $data = DB::select("select * from sach order by gia_ban asc limit 0,10");
        return view("sach.index", compact("data"));
    }
    function theloai($id)
    {
        $data = DB::select("select * from sach where the_loai = ? limit 0,10",[$id]);
        return view("sach.index", compact("data"));
    }

}
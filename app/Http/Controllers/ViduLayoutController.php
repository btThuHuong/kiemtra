<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// THÊM DÒNG NÀY VÀO ĐÂY:
use Illuminate\Support\Facades\DB; 

class ViduLayoutController extends Controller
{
    // Hàm cho trang 2
    public function trang2()
    {
        return view("vidulayout.trang2");
    }

    
    public function sach()
    {
        $data = DB::select("select * from sach order by gia_ban asc limit 0,8");
        return view("sach.index", compact("data"));
    }

    public function theloai($id)
    {
    $data = DB::select("select * from sach where the_loai = ?",[$id]);
    return view("sach.index", compact("data"));
    }

    public function chitiet($id)
    {
        $book = DB::select("select * from sach where id = ?", [$id]);
        $data = $book[0];    
        return view("sach.chitiet", compact("data"));
    }

 
}
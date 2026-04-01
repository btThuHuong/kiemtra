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

    public function cartadd(Request $request) {
        $id = $request->id;
        $num = $request->num;
        $cart = session()->get("cart", []);

        if(isset($cart[$id])) {
            $cart[$id] += $num;
        } else {
            $cart[$id] = $num;
        }

        session()->put("cart", $cart);
        return count($cart); // Trả về số lượng để Ajax hiển thị
    }


    public function order()
    {
        $cart=[];
        $data =[];
        $quantity = [];
        if(session()->has('cart'))
        {
            $cart = session("cart");
            $list_book = "";
            foreach($cart as $id=>$value)
            {
                $quantity[$id] = $value;
                $list_book .=$id.", ";
            }
        $list_book = substr($list_book, 0,strlen($list_book)-2);
        $data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();
        }
        return view("sach.order",compact("quantity","data"));
    }


    public function cartdelete(Request $request)
    {
        $request->validate([
            "id"=>["required","numeric"]
        ]);
        $id = $request->id;
        $total = 0;
        $cart = [];
        if(session()->has('cart'))
        {
            $cart = session()->get("cart");
            unset($cart[$id]);
        }
        session()->put("cart",$cart);
        return redirect()->route('order');
    }

    public function ordercreate(Request $request)
    {
        $request->validate([
        "hinh_thuc_thanh_toan"=>["required","numeric"]
        ]);
        $data = [];
        $quantity = [];
        if(session()->has('cart'))
        {
        $order = ["ngay_dat_hang"=>DB::raw("now()"),"tinh_trang"=>1,
        "hinh_thuc_thanh_toan"=>$request->hinh_thuc_thanh_toan,
        "user_id"=>Auth::user()->id];
        DB::transaction(function () use ($order) {
        $id_don_hang = DB::table("don_hang")->insertGetId($order);
        $cart = session("cart");
        $list_book = "";
        $quantity = [];
        foreach($cart as $id=>$value)
        {
        $quantity[$id] = $value;
        $list_book .=$id.", ";
        }
        $list_book = substr($list_book, 0,strlen($list_book)-2);
        $data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();
        $detail = [];
        foreach($data as $row)
        {
        $detail[] = ["ma_don_hang"=>$id_don_hang,"sach_id"=>$row->id,
        "so_luong"=>$quantity[$row->id],"don_gia"=>$row->gia_ban];
        }
        DB::table("chi_tiet_don_hang")->insert($detail);
        session()->forget('cart');
        });
        }
        return view("sach.order", compact('data','quantity'));
    }


}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TestSendEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function bookview(Request $request)
    {
        $the_loai = $request->input("the_loai");
        $data = [];
        if($the_loai!="")
        $data = DB::select("select * from sach where the_loai = ?",[$the_loai]);
        else
        $data = DB::select("select * from sach order by gia_ban asc limit 0,10");
        return view("sach.bookview", compact("data"));
    }

    public function cartadd(Request $request)
    {
        $request->validate([
            "id" => ["required", "numeric"],
            "num" => ["required", "numeric"]
        ]);

        $id = $request->id;
        $num = $request->num;
        $cart = [];

        if(session()->has('cart')) {
            $cart = session()->get("cart");
            if(isset($cart[$id])) {
                $cart[$id] += $num; 
            } else {
                $cart[$id] = $num;
            }
        } else {
            $cart[$id] = $num;
        }

        session()->put("cart", $cart);
        return count($cart); 
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
        $user = Auth::user();
        if(session()->has('cart'))
        {
        $order = ["ngay_dat_hang"=>DB::raw("now()"),"tinh_trang"=>1,
        "hinh_thuc_thanh_toan"=>$request->hinh_thuc_thanh_toan,
        "user_id"=> $user->id];
        $donHang = [];
        DB::transaction(function () use ($order, &$donHang) {
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
        
        $donHang = DB::select("select * from chi_tiet_don_hang c, sach s 
                                   where c.sach_id = s.id 
                                   and c.ma_don_hang = ?", [$id_don_hang]);
        session()->forget('cart');
        });
        }
        $user->notify(new TestSendEmail($donHang));
        return view("sach.order", compact('data','quantity'));
    }

    function testemail()
    {
        $user = Auth::user();

        if ($user) {
            Notification::route('mail', $user->email)
                ->notify(new TestSendEmail());
            
            return "Mail test đã được gửi tới: " . $user->email;
        }

        return "Vui lòng đăng nhập để nhận mail test.";
    }
  
    function testemail2()
    {
    $user = Auth::user();
    if (!$user) {
        return "Bạn cần đăng nhập để thực hiện chức năng này.";
    }
    $donHang = DB::select("select * from chi_tiet_don_hang c, sach s
    where c.sach_id = s.id
    and c.ma_don_hang = 7");
    $user->notify(new TestSendEmail($donHang));
    return "Đã gửi mail đến: " . $user->email;
    }

}
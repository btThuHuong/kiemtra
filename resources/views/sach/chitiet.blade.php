<x-book-layout>
    <x-slot name="title">
        Chi tiết sách
    </x-slot>

    <div class="row">
        <div class="col-5">
            <img src="{{asset('hinh/image/'.$data->file_anh_bia)}}" width="100%">
        </div>
        <div class="col-7">
            <h3>{{$data->tieu_de}}</h3>
            <p>Nhà cung cấp: <b>{{$data->nha_cung_cap}}</b></p>
            <p>Nhà xuất bản: <b>{{$data->nha_xuat_ban}}</b></p>
            <p>Tác giả: <b>{{$data->tac_gia}}</b></p>
            <p>Hình thức bìa: <b>{{$data->hinh_thuc_bia}}</b></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <h5>Mô tả:</h5>
            <p style="text-align: justify;">{{$data->mo_ta}}</p>
        </div>
    </div>
</x-book-layout>
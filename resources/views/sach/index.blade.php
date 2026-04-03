<x-book-layout>
    <x-slot name='title'>
        Sách
    </x-slot>

    <div id='book-view-div'>
        <div class='list-book'>
            @foreach($data as $row)
                <div class='book'>
                    <a href="{{ url('sach/chitiet/'.$row->id) }}">
                        <img src="{{ asset('hinh/image/'.$row->file_anh_bia) }}" width='200px' height='200px'><br>
                        <b>{{ $row->tieu_de }}</b><br/>
                        <i>{{ number_format($row->gia_ban,0,",",".") }}đ</i>
                    </a>
                    <div class='btn-add-product'>
                        <button class='btn btn-success btn-sm mb-1 add-product' book_id="{{ $row->id }}">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".menu-the-loai").click(function() {
            the_loai = $(this).attr("the_loai");
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "{{ route('bookview') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "the_loai": the_loai
                },
                success: function(data) {
                    $("#book-view-div").html(data);
                }
            });
        });
    </script>
    <style>
        .book
        {
        position:relative;
        margin:10px;
        text-align:center;
        padding-bottom:35px;
        }
        .btn-add-product
        {
        position:absolute;
        bottom:0;
        width:100%;
        }
    </style>

    <script>
        $(document).ready(function(){
        $(document).on("click", ".add-product", function(){
        id = $(this).attr("book_id");
        num = 1;
            $.ajax({
                type:"POST",
                dataType:"json",
                url: "{{route('cartadd')}}",
                data:{"_token": "{{ csrf_token() }}","id":id,"num":num},
                beforeSend:function(){},
                success:function(data){
                    $("#cart-number-product").html(data);
                },
                error: function (xhr,status,error){},
                complete: function(xhr,status){}
            });
            });
        });
    </script>


</x-book-layout>
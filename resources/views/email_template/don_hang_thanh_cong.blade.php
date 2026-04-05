<html>
<head>
    <style>
        .book-table {
            border-collapse: collapse;
            width: 100%;
        }
        .book-table tr th {
            text-align: center;
            background-color: #f2f2f2;
        }
        .book-table tr th, .book-table tr td {
            border: 1px solid #000;
            padding: 8px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div style='text-align:center; font-weight:bold; color:#15c; font-size: 18px; margin-bottom: 20px;'>
        THÔNG TIN ĐƠN HÀNG CỦA BẠN
    </div>

    <table class='book-table' style='margin:0 auto; width:90%'>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tongTien = 0;
            @endphp
            
            @foreach($data as $key => $row)
                @php
                    $thanhTien = $row->so_luong * $row->don_gia;
                    $tongTien += $thanhTien;
                @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $row->tieu_de }}</td>
                    <td class="text-center">{{ $row->so_luong }}</td>
                    <td class="text-right">{{ number_format($row->don_gia, 0, ',', '.') }}đ</td>
                    <td class="text-right">{{ number_format($thanhTien, 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
            
            <tr style="background-color: #eee;">
                <td colspan='4' align='center'><b>Tổng cộng giá trị đơn hàng</b></td>
                <td class="text-right" style="color: red;">
                    <b>{{ number_format($tongTien, 0, ',', '.') }}đ</b>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px;">
        Cảm ơn bạn đã tin tưởng đặt sách!
    </p>
</body>
</html>
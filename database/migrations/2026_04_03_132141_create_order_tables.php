<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tạo bảng don_hang (Lưu thông tin tổng quát đơn hàng)
        Schema::create('don_hang', function (Blueprint $table) {
            $table->integer('ma_don_hang')->autoIncrement(); // int(11) NOT NULL AUTO_INCREMENT [cite: 316, 317]
            $table->dateTime('ngay_dat_hang'); // datetime NOT NULL [cite: 318]
            $table->smallInteger('tinh_trang'); // smallint(6) NOT NULL [cite: 319]
            $table->smallInteger('hinh_thuc_thanh_toan'); // hinh thuc thanh toan smallint(6) NOT NULL [cite: 320]
            $table->integer('user_id'); // user id int(11) NOT NULL [cite: 321]
            
            $table->primary('ma_don_hang'); // PRIMARY KEY (ma don hang) [cite: 322]
        });

        // 2. Tạo bảng chi_tiet_don_hang (Lưu chi tiết từng sản phẩm trong đơn)
        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->integer('ma_don_hang'); // ma don hang int(11) NOT NULL [cite: 326]
            $table->integer('sach_id'); // sach id int(11) NOT NULL [cite: 327, 329]
            $table->integer('so_luong'); // so luong int(11) NOT NULL [cite: 328, 330]
            $table->integer('don_gia'); // don_gia int(11) NOT NULL [cite: 331]

            // Khóa chính kết hợp (Composite Primary Key) 
            $table->primary(['ma_don_hang', 'sach_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hang');
        Schema::dropIfExists('don_hang');
    }
};

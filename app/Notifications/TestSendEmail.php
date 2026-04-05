<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestSendEmail extends Notification
{
    use Queueable;

    // Khai báo biến để lưu trữ dữ liệu truyền từ Controller
    private $data;

    /**
     * Khởi tạo Notification với dữ liệu đơn hàng
     */
    public function __construct($data)
    {
        $this->data = $data; // Lưu dữ liệu vào biến nội bộ
    }

    /**
     * Xác định kênh gửi thông báo (ở đây là Email)
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Thiết lập nội dung Email
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Đặt hàng thành công")
            
            ->view("email_template.don_hang_thanh_cong", ["data" => $this->data]); 
    }
}

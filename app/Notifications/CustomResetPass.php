<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPass extends Notification
{
    use Queueable;

    // 1. Thêm thuộc tính token
    private $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        // 2. Gán giá trị token được truyền vào
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // 3. Tạo link reset password với token
        $url = route("password.reset", ["token" => $this->token]);

        // 4. Trả về view tùy chỉnh
        return (new MailMessage)
            ->subject('Lấy lại mật khẩu')
            ->view('email_template.reset_pass', compact("url"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
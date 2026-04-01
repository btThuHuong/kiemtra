<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Bước 1: Thêm dòng này 
use App\Notifications\CustomResetPass; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Bước 2: Thêm hàm này vào cuối class [cite: 191, 192]
     * Viết lại phương thức để sử dụng Notification tùy chỉnh
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPass($token)); // [cite: 194]
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
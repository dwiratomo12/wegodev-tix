<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $fillable = [
        'user_id',
        'NIM',
        'nama_depan',
        'nama_belakang',
        'email',
        'jenis_kelamin',
        'agama',
        'alamat',
    ];
}
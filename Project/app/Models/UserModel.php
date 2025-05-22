<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // ✅ PASTIKAN nama tabel benar
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username', 'password', 'level', 'gambar', 'remember_token'];
}

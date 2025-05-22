<?php

namespace App\Models;
use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table      = 'petugas';
    protected $primaryKey = 'id_petugas';
    protected $allowedFields = [
        'id_user', 'nama_petugas', 'alamat_petugas', 'no_hp_petugas'
    ];

   public function getJoinOne(array $joins = [], $id_petugas)
{
    $builder = $this->db->table('petugas');
    $builder->select('petugas.*, users.username');

    if (in_array('users', $joins)) {
        $builder->join('users', 'users.id_user = petugas.id_user', 'left');
    }

    $builder->where('petugas.id_petugas', $id_petugas);

    // Mengambil data dan mengembalikan hasil sebagai array
    return $builder->get()->getRowArray();
}

public function getProfilLengkap($id_user)
{
    return $this->select([
            'petugas.id_petugas',
            'petugas.nama_petugas',
            'petugas.alamat_petugas',
            'petugas.no_hp_petugas',
            'users.gambar',
            'users.username',
            'users.level'
        ])
        ->join('users', 'users.id_user = petugas.id_user')
        ->where('petugas.id_user', $id_user)
        ->first();
}



}

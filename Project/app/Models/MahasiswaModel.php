<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $allowedFields = ['id_user', 'id_spp', 'id_jurusan', 'nim', 'nama_mahasiswa', 'alamat_mahasiswa', 'no_telepon_mahasiswa'];
    
 // Untuk mengambil semua mahasiswa
public function getMahasiswaJoinAll()
{
    return $this->select('mahasiswa.*, spp.tahun, spp.nominal, jurusan.nama_jurusan, users.username, users.gambar')
                ->join('spp', 'spp.id_spp = mahasiswa.id_spp')
                ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan')
                ->join('users', 'users.id_user = mahasiswa.id_user')
                ->findAll();
}

// Untuk mengambil detail 1 mahasiswa berdasarkan id
public function getMahasiswaJoin($id)
{
    return $this->select('mahasiswa.*, spp.tahun, spp.nominal, jurusan.nama_jurusan, users.username, users.gambar')
                ->join('spp', 'spp.id_spp = mahasiswa.id_spp')
                ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan')
                ->join('users', 'users.id_user = mahasiswa.id_user')
                ->where('id_mahasiswa', $id)
                ->first();
}


 public function getProfilLengkap($id_user)
{
    return $this->select('mahasiswa.*, jurusan.nama_jurusan, spp.nominal, spp.tahun, users.gambar')
                ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan', 'left')
                ->join('spp', 'spp.id_spp = mahasiswa.id_spp', 'left')
                ->join('users', 'users.id_user = mahasiswa.id_user', 'left') // JOIN KE USERS
                ->where('mahasiswa.id_user', $id_user)
                ->first();
}


    public function getMahasiswa($id)
    {
        return $this->where('id_mahasiswa', $id)
                    ->first();
    }

  public function getJoinOne($tables, $where)
    {
        return $this->db->table($this->table)
            ->join($tables[0], 'mahasiswa.id_user = users.id_user') // Join dengan tabel users
            ->join($tables[1], 'mahasiswa.id_spp = spp.id_spp') // Join dengan tabel spp
            ->join($tables[2], 'mahasiswa.id_jurusan = jurusan.id_jurusan') // Ganti id_kelas menjadi id_jurusan
            ->where($where)
            ->get()
            ->getRowArray(); // Mengembalikan satu baris data
    }

}

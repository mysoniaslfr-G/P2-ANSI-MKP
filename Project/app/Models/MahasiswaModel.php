<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mahasiswa';
    protected $primaryKey    = 'id_mahasiswa';
    protected $allowedFields = [
        'id_user',
        'id_spp',
        'id_jurusan',
        'nim',
        'nama_mahasiswa',
        'alamat_mahasiswa',
        'no_telepon_mahasiswa'
    ];

    // ============================================================
    // AMBIL SEMUA MAHASISWA DENGAN JOIN KE SPP, JURUSAN, USERS
    // ============================================================
    public function getMahasiswaJoinAll()
    {
        return $this->select('
                    mahasiswa.*,
                    spp.tahun,
                    spp.nominal,
                    jurusan.nama_prodi,
                    jurusan.kode_prodi,
                    users.username,
                    users.gambar
                ')
                ->join('spp', 'spp.id_spp = mahasiswa.id_spp', 'left')
                ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan', 'left')
                ->join('users', 'users.id_user = mahasiswa.id_user', 'left')
                ->findAll();
    }

    // ============================================================
    // AMBIL SATU MAHASISWA DENGAN JOIN KE SPP, JURUSAN, USERS
    // ============================================================
    public function getMahasiswaJoin($id)
    {
        return $this->select('
                    mahasiswa.*,
                    spp.tahun,
                    spp.nominal,
                    jurusan.nama_prodi,
                    jurusan.kode_prodi,
                    users.username,
                    users.gambar
                ')
                ->join('spp', 'spp.id_spp = mahasiswa.id_spp', 'left')
                ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan', 'left')
                ->join('users', 'users.id_user = mahasiswa.id_user', 'left')
                ->where('mahasiswa.id_mahasiswa', $id)
                ->first();
    }

    // ============================================================
    // AMBIL PROFIL LENGKAP MAHASISWA BERDASARKAN USER
    // ============================================================
    public function getProfilLengkap($id_user)
    {
        return $this->select('
                    mahasiswa.*,
                    jurusan.nama_prodi,
                    spp.nominal,
                    spp.tahun,
                    spp.id_jurusan,
                    users.gambar
                ')
                ->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan', 'left')
                ->join('spp', 'spp.id_spp = mahasiswa.id_spp', 'left')
                ->join('users', 'users.id_user = mahasiswa.id_user', 'left')
                ->where('mahasiswa.id_user', $id_user)
                ->first();
    }

    // ============================================================
    // AMBIL MAHASISWA BERDASARKAN ID MAHASISWA SAJA
    // ============================================================
    public function getMahasiswa($id)
    {
        return $this->where('id_mahasiswa', $id)->first();
    }

    // ============================================================
    // AMBIL DATA JOIN 3 TABEL BERDASARKAN KONDISI (FLEXIBEL)
    // ============================================================
    public function getJoinOne($tables, $where)
    {
        return $this->db->table($this->table)
                        ->join($tables[0], 'mahasiswa.id_user = users.id_user', 'left')
                        ->join($tables[1], 'mahasiswa.id_spp = spp.id_spp', 'left')
                        ->join($tables[2], 'mahasiswa.id_jurusan = jurusan.id_jurusan', 'left')
                        ->where($where)
                        ->get()
                        ->getRowArray();
    }
}

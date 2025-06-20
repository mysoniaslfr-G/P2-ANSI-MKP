<?php

namespace App\Models;
use CodeIgniter\Model;

class SppModel extends Model
{
    protected $table      = 'spp';
    protected $primaryKey = 'id_spp';
    protected $allowedFields = ['tahun', 'nominal', 'id_jurusan'];

   public function getAllSppWithProdi()
{
    $builder = $this->db->table('spp s');
    $builder->select('s.*, j.kode_prodi, j.nama_prodi'); // ✅ diperbaiki
    $builder->join('jurusan j', 'j.id_jurusan = s.id_jurusan', 'left'); 
    return $builder->get()->getResultArray();
}


    public function getSemesterTerisiByMahasiswa($id_mahasiswa)
    {
        $builder = $this->db->table('pembayaran');
        $builder->select('pembayaran.semester, s.tahun, s.id_jurusan, j.kode_prodi'); // Menambahkan kode_prodi ke select
        $builder->join('spp s', 's.id_spp = pembayaran.id_spp', 'left');
        $builder->join('jurusan j', 'j.id_jurusan = s.id_jurusan', 'left'); // Melakukan join dengan tabel jurusan
        $builder->where('pembayaran.id_mahasiswa', $id_mahasiswa);
        $builder->groupBy('pembayaran.semester');

        $result = $builder->get()->getResultArray();

        $semesters = [];
        foreach ($result as $row) {
            $semesters[] = [
                'semester' => $row['semester'],
                'tahun' => $row['tahun'],
                'id_jurusan' => $row['id_jurusan'],
                'kode_prodi' => $row['kode_prodi'] // Menyimpan kode_prodi
            ]; 
        }
        return $semesters;
    }
}

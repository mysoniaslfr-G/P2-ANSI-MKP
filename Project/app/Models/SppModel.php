<?php

namespace App\Models;
use CodeIgniter\Model;

class SppModel extends Model
{
    protected $table      = 'spp';
    protected $primaryKey = 'id_spp';
    protected $allowedFields = ['tahun', 'nominal'];

    public function getSemesterTerisiByMahasiswa($id_mahasiswa)
{
    $builder = $this->db->table('pembayaran');
    $builder->select('pembayaran.semester, s.tahun');
    $builder->join('spp s', 's.id_spp = pembayaran.id_spp', 'left');
    $builder->where('pembayaran.id_mahasiswa', $id_mahasiswa);
    $builder->groupBy('pembayaran.semester');

    $result = $builder->get()->getResultArray();

    $semesters = [];
    foreach ($result as $row) {
        $semesters[] = $row['semester']; 
    }
    return $semesters;
}

}

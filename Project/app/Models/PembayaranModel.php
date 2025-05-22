<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = [
        'id_petugas', 'id_mahasiswa', 'id_spp', 'semester', 
        'tgl_bayar', 'jumlah_bayar', 'bukti_bayar', 'status_bayar'
    ];


       // Membuat data pembayaran berdasarkan semester yang dipilih
    // Membuat data pembayaran per semester untuk satu mahasiswa
   public function createPembayaran($id_mahasiswa, $id_petugas, $id_spp, $semesterDipilih = [])
{
    if (!$id_petugas || !$id_mahasiswa || !$id_spp || empty($semesterDipilih)) {
        return false;
    }

    $tahun = date('Y');
    $tgl_bayar = null;

    $data = [];
    foreach ($semesterDipilih as $index => $semester) {
        $data[] = [
            'id_petugas'    => $id_petugas,
            'id_mahasiswa'  => $id_mahasiswa,
            'id_spp'        => $id_spp,
            'semester'      => $semester,
            'tgl_bayar'     => $tgl_bayar,
            'jumlah_bayar'  => null,
        ];
    }

    return $this->insertBatch($data);
}

    
    

    // Join fleksibel untuk banyak tabel
    public function getJoinAll($tables = [], $where = null)
    {
        $builder = $this->builder();

        foreach ($tables as $table) {
            $builder->join($table, "$table.id_$table = pembayaran.id_$table", 'left');
        }

        if ($where) {
            $builder->where($where);
        }

        return $builder->orderBy('spp.tahun', 'ASC')->orderBy('spp.semester', 'ASC')->get()->getResultArray();
    }

    // Join statis dengan 2 tabel (spp dan petugas)
    public function getJoinAllStatic($tables, $where)
    {
        return $this->db->table('pembayaran')
            ->join($tables[0], 'pembayaran.id_spp = spp.id_spp')
            ->join($tables[1], 'pembayaran.id_petugas = petugas.id_petugas')
            ->where($where)
            ->get()
            ->getResultArray();
    }

    // Menampilkan pembayaran berdasarkan ID mahasiswa
    public function getPembayaranByMahasiswa($id_mahasiswa)
    {
        return $this->select('pembayaran.*, spp.tahun, spp.nominal, petugas.nama_petugas')
                    ->join('spp', 'spp.id_spp = pembayaran.id_spp')
                    ->join('petugas', 'petugas.id_petugas = pembayaran.id_petugas')
                    ->where('pembayaran.id_mahasiswa', $id_mahasiswa)
                    ->findAll();
    }

    public function getLaporanKeuangan($filter = [])
{
    $builder = $this->db->table('pembayaran');
    $builder->select('
        mahasiswa.nim,
        mahasiswa.nama_mahasiswa,
        jurusan.nama_jurusan,
        spp.nominal,
        spp.tahun,
        pembayaran.semester,
        pembayaran.jumlah_bayar,
        pembayaran.tgl_bayar
    ');
    $builder->join('mahasiswa', 'mahasiswa.id_mahasiswa = pembayaran.id_mahasiswa');
    $builder->join('spp', 'spp.id_spp = pembayaran.id_spp');
    $builder->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan');

    if (!empty($filter['jurusan'])) {
        $builder->where('jurusan.id_jurusan', $filter['jurusan']);
    }

    if (!empty($filter['tahun'])) {
    $builder->where('spp.tahun', $filter['tahun']);
}


    if (!empty($filter['semester'])) {
        $builder->where('pembayaran.semester', $filter['semester']);
    }

    return $builder->get()->getResultArray();
}

}

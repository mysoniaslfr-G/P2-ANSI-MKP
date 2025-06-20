<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table         = 'pembayaran';
    protected $primaryKey    = 'id_pembayaran';
    protected $allowedFields = ['id_mahasiswa', 'id_spp', 'semester'];

    // ============================================================
    // BUAT PEMBAYARAN & TRANSAKSI DEFAULT
    // ============================================================
    public function createPembayaran($id_mahasiswa, $id_spp, $semesterDipilih = [])
    {
        if (!$id_mahasiswa || !$id_spp || empty($semesterDipilih)) {
            return false;
        }

        $data = [];
        foreach ($semesterDipilih as $semester) {
            $data[] = [
                'id_mahasiswa' => $id_mahasiswa,
                'id_spp'       => $id_spp,
                'semester'     => $semester
            ];
        }

        if ($this->insertBatch($data)) {
            $jumlah        = count($semesterDipilih);
            $pembayaranBaru = $this->where('id_mahasiswa', $id_mahasiswa)
                                   ->orderBy('id_pembayaran', 'DESC')
                                   ->limit($jumlah)
                                   ->findAll();

            $id_petugas = session()->get('id_petugas');

            foreach ($pembayaranBaru as $p) {
                model('TransaksiModel')->createTransaksiDefault($p['id_pembayaran'], $id_petugas);
            }

            return true;
        }

        return false;
    }

    // ============================================================
    // AMBIL PEMBAYARAN BERDASARKAN MAHASISWA (TANPA JOIN TRANSAKSI)
    // ============================================================
    public function getPembayaranByMahasiswa($id_mahasiswa)
    {
        return $this->select('
                pembayaran.id_pembayaran,
                pembayaran.id_mahasiswa,
                pembayaran.id_spp,
                pembayaran.semester,
                spp.tahun,
                spp.nominal
            ')
            ->join('spp', 'spp.id_spp = pembayaran.id_spp')
            ->where('pembayaran.id_mahasiswa', $id_mahasiswa)
            ->orderBy('spp.tahun', 'ASC')
            ->orderBy('pembayaran.semester', 'ASC')
            ->findAll();
    }

    // ============================================================
    // AMBIL PEMBAYARAN BESERTA TRANSAKSI DAN PETUGAS
    // ============================================================
    public function getPembayaranWithTransaksi($id_mahasiswa)
    {
        return $this->db->table('pembayaran')
            ->select('
                pembayaran.id_pembayaran,
                pembayaran.semester,
                spp.tahun,
                spp.nominal,
                transaksi.id_transaksi,
                transaksi.tgl_bayar,
                transaksi.jumlah_bayar,
                transaksi.bukti_bayar,
                transaksi.status,
                petugas.nama_petugas
            ')
            ->join('spp', 'spp.id_spp = pembayaran.id_spp')
            ->join('transaksi', 'transaksi.id_pembayaran = pembayaran.id_pembayaran', 'left')
            ->join('petugas', 'petugas.id_petugas = transaksi.id_petugas', 'left')  
            ->where('pembayaran.id_mahasiswa', $id_mahasiswa)
            ->get()
            ->getResultArray();
    }

    // ============================================================
    // JOIN KE TABEL DINAMIS
    // ============================================================
    public function getJoinAll($tables = [], $where = null)
    {
        $builder = $this->builder();

        foreach ($tables as $table) {
            $builder->join($table, "$table.id_$table = pembayaran.id_$table", 'left');
        }

        if ($where) {
            $builder->where($where);
        }

        return $builder->orderBy('spp.tahun', 'ASC')
                       ->orderBy('spp.semester', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    // ============================================================
    // LAPORAN KEUANGAN MAHASISWA (FILTER JURUSAN, TAHUN, SEMESTER)
    // ============================================================
    public function getLaporanKeuangan($filter = [])
    {
        $builder = $this->db->table('pembayaran');
        $builder->select('
            mahasiswa.nim,
            mahasiswa.nama_mahasiswa,
            jurusan.kode_prodi,
            jurusan.nama_prodi,
            spp.nominal,
            spp.tahun,
            pembayaran.semester,
            transaksi.jumlah_bayar,
            transaksi.tgl_bayar
        ');
        $builder->join('mahasiswa', 'mahasiswa.id_mahasiswa = pembayaran.id_mahasiswa');
        $builder->join('spp', 'spp.id_spp = pembayaran.id_spp');
        $builder->join('jurusan', 'jurusan.id_jurusan = mahasiswa.id_jurusan');
        $builder->join('transaksi', 'transaksi.id_pembayaran = pembayaran.id_pembayaran', 'left');

        if (!empty($filter['jurusan'])) {
            $builder->where('jurusan.id_jurusan', $filter['jurusan']);
        }

        if (!empty($filter['tahun'])) {
            $builder->where('spp.tahun', $filter['tahun']);
        }

        return $builder->get()->getResultArray();
    }

    
}

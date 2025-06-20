<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table         = 'transaksi';
    protected $primaryKey    = 'id_transaksi';
    protected $allowedFields = [
        'id_pembayaran',
        'tgl_bayar',
        'jumlah_bayar',
        'bukti_bayar',
        'status',
        'id_petugas'
    ];

    // ============================================================
    // AMBIL TRANSAKSI BERDASARKAN ID PEMBAYARAN
    // ============================================================
    public function getTransaksiByPembayaran($id_pembayaran)
{
      return $this->select('transaksi.*, users.username as nama_petugas')
                ->join('users', 'users.id_user = transaksi.id_petugas', 'left')
                ->where('transaksi.id_pembayaran', $id_pembayaran)
                ->findAll();
}

   

    // ============================================================
    // BUAT TRANSAKSI DEFAULT (digunakan saat insert pembayaran)
    // ============================================================
    public function createTransaksiDefault($id_pembayaran, $id_petugas)
    {
        return $this->insert([
            'id_pembayaran' => $id_pembayaran,
            'id_petugas'    => $id_petugas,
            'jumlah_bayar'  => 0,
            'status'        => 'pending',
            'tgl_bayar'     => null,
            'bukti_bayar'   => null
        ]);
    }

    // ============================================================
    // AMBIL SEMUA TRANSAKSI DENGAN JOIN KE PEMBAYARAN & SPP
    // ============================================================
    public function getAllWithPembayaran($id_mahasiswa = null)
    {
        $builder = $this->db->table('pembayaran')
            ->select('
                pembayaran.*,
                spp.tahun,
                spp.nominal,
                transaksi.jumlah_bayar,
                transaksi.tgl_bayar,
                petugas.nama_petugas
            ')
            ->join('spp', 'spp.id_spp = pembayaran.id_spp')
            ->join('transaksi', 'transaksi.id_pembayaran = pembayaran.id_pembayaran', 'left')
            ->join('petugas', 'petugas.id_petugas = transaksi.id_petugas', 'left');

        if ($id_mahasiswa !== null) {
            $builder->where('pembayaran.id_mahasiswa', $id_mahasiswa);
        }

        return $builder->get()->getResultArray();
    }

    // ============================================================
    // SIMPAN TRANSAKSI BARU
    // ============================================================
    public function simpanTransaksi($data)
    {
        return $this->insert($data);
    }
}

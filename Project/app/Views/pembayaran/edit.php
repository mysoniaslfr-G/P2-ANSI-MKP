<?= $this->include('tamplate/header') ?>
<div class="row">
  <div class="col-md-6"> <!-- Sesuaikan dengan kolom yang sama -->
    <div class="card card-warning"> <!-- Menggunakan warna kuning -->
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit"></i> Edit Bukti Pembayaran Ditolak</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <form action="<?= base_url('pembayaran/update/' . $transaksi['id_transaksi']) ?>" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <label for="jumlah_bayar">Jumlah Pembayaran</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" value="<?= esc($transaksi['jumlah_bayar']) ?>" readonly>
          </div>
          <div class="form-group">
            <label for="bukti_bayar">Upload Ulang Bukti Pembayaran</label>
            <div class="mb-2">
              <?php if (!empty($transaksi['bukti_bayar'])): ?>
                <img src="<?= base_url('uploads/' . $transaksi['bukti_bayar']) ?>" width="100" class="img-thumbnail">
              <?php endif; ?>
            </div>
            <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" required> <!-- Ganti class menjadi form-control untuk konsistensi -->
          </div>
        </div>
        <div class="card-footer">
          <a href="<?= base_url('/pembayaran/input') ?>" class="btn btn-danger">Batal</a> <!-- Tombol batal -->
          <button type="submit" class="btn btn-warning float-right"><i class="fas fa-sync-alt"></i> Update</button> <!-- Tombol update -->
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer') ?>

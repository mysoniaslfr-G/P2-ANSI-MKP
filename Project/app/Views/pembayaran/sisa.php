<?= $this->include('tamplate/header') ?>

<div class="row">
  <div class="col-md-6"> <!-- Menggunakan kolom yang sama -->
    <div class="card card-danger"> <!-- Menggunakan warna merah -->
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Input Sisa Pembayaran</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <form action="<?= base_url('/pembayaran/storeSisa') ?>" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <input type="hidden" name="id_spp" value="<?= $id_spp ?>">
          <div class="form-group">
            <label for="jumlah_bayar">Jumlah Pembayaran</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required placeholder="Masukkan jumlah sisa pembayaran">
          </div>
          <div class="form-group">
            <label for="bukti_bayar">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" required> <!-- Ganti class menjadi form-control untuk konsistensi -->
          </div>
        </div>
        <div class="card-footer"> <!-- Mengatur posisi tombol di footer -->
          <a href="<?= base_url('/pembayaran/input') ?>" class="btn btn-secondary">Batal</a> 
          <button type="submit" class="btn btn-danger float-right"><i class="fas fa-save"></i> Simpan</button> 
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer') ?>

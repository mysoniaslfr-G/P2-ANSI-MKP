<?= $this->include('tamplate/header') ?>

<div class="row">
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Upload Bukti Pembayaran</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <!-- FORM -->
      <form action="<?= base_url('/pembayaran/simpanBayar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
          <!-- Hidden Inputs -->
          <input type="hidden" name="id_transaksi" value="<?= esc($dataTransaksi['id_transaksi']) ?>">
          <input type="hidden" id="sisa_tagihan" value="<?= esc($sisa) ?>">

          <!-- Input Jumlah Bayar -->
          <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar (maks: Rp <?= number_format($sisa, 0, ',', '.') ?>)</label>
            <input 
              type="number" 
              id="jumlah_bayar" 
              name="jumlah_bayar" 
              class="form-control" 
              value="<?= old('jumlah_bayar') ?>" 
              max="<?= $sisa ?>"
              required
            >
            <small id="peringatanLebih" class="text-danger d-none">⚠️ Jumlah bayar melebihi sisa tagihan!</small>
          </div>

          <!-- Upload Bukti -->
          <div class="form-group">
            <label for="bukti_bayar" class="form-label fw-bold">Upload Bukti Bayar</label>
            <input 
              type="file" 
              id="bukti_bayar" 
              name="bukti_bayar" 
              class="form-control" 
              accept=".jpg,.jpeg,.png" 
              required
            />
            <small class="form-text text-muted">
              Format file: JPG, JPEG, PNG. Maksimal ukuran 2MB.
            </small>
          </div>
        </div>

        <!-- Tombol -->
        <div class="card-footer">
          <a href="<?= base_url('/pembayaran/input') ?>" class="btn btn-danger">Batal</a>
          <button type="submit" class="btn btn-primary float-right" id="submitBtn">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const inputJumlah = document.getElementById('jumlah_bayar');
  const sisa = parseInt(document.getElementById('sisa_tagihan').value);
  const warning = document.getElementById('peringatanLebih');
  const submitBtn = document.getElementById('submitBtn');

  inputJumlah.addEventListener('input', function () {
    const nilai = parseInt(this.value);
    if (nilai > sisa) {
      warning.classList.remove('d-none');
      submitBtn.disabled = true;
    } else {
      warning.classList.add('d-none');
      submitBtn.disabled = false;
    }
  });
});
</script>

<?= $this->include('tamplate/footer') ?>

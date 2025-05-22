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

      <form action="<?= base_url('/pembayaran/input/bayar') ?>" method="post" enctype="multipart/form-data">
         <?= csrf_field() ?>
        <div class="card-body">
          <input type="hidden" name="id_pembayaran" value="<?= isset($id_pembayaran) ? $id_pembayaran : '' ?>">

          <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar</label>
            <input type="number" id="jumlah_bayar" name="jumlah_bayar" class="form-control" 
              value="<?= isset($jumlah_bayar) ? number_format($jumlah_bayar,0,',','.') : '' ?>" required>
          </div>

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

        <div class="card-footer">
          <a href="<?= base_url('/pembayaran/input') ?>" class="btn btn-danger">Batal</a>
          <button type="submit" class="btn btn-primary float-right">Upload</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?= $this->include('tamplate/footer') ?>

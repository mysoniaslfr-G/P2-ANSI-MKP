<?= $this->include('tamplate/header'); ?>
<form action="<?= base_url('/petugas/store'); ?>" method="post">
  <?= csrf_field(); ?> <!-- Tambahkan ini jika CSRF aktif -->
  <div class="row">
    <div class="col-md-6">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">General</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="nama_petugas">Nama Lengkap</label>
            <input type="text" id="nama_petugas" name="nama_petugas" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="no_hp_petugas">Nomor HP</label>
            <input type="text" id="no_hp_petugas" name="no_hp_petugas" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="alamat_petugas">Alamat</label>
            <textarea id="alamat_petugas" name="alamat_petugas" class="form-control" rows="4" required></textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">Account</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="level">Level</label>
            <select name="level" id="level" class="form-control" required>
            <option value="">--Pilih Level--</option>
            <option value="1">Admin</option>
            <option value="2">Petugas</option>
            </select>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <a href="<?= base_url('/petugas'); ?>" class="btn btn-danger">Cancel</a>
      <input type="submit" value="Tambah Data" class="btn btn-primary float-right">
    </div>
  </div>
</form>
<?= $this->include('tamplate/footer'); ?>

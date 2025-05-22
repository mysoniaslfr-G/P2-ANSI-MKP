<?= $this->include('tamplate/header') ?>
<form action="<?= base_url('/mahasiswa/store') ?>" method="post">
   <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Profil</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" required>
              </div>
              
              <div class="form-group">
                <label for="nama_mahasiswa">Nama Lengkap</label>
                <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" class="form-control" required>
              </div>
              
              <div class="form-group">
                <label for="alamat_mahasiswa">Alamat</label>
                <textarea id="alamat_mahasiswa" name="alamat_mahasiswa" class="form-control" rows="4"></textarea>
              </div>

              <div class="form-group">
                <label for="no_telepon_mahasiswa">Nomor HP</label>
                <input type="text" id="no_telepon_mahasiswa" name="no_telepon_mahasiswa" class="form-control">
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Info</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">

              <div class="form-group">
                <label for="id_jurusan">Jurusan</label>
                <select id="id_jurusan" name="id_jurusan" class="form-control custom-select">
                  <?php foreach ($jurusan as $j): ?>
                      <option value="<?= $j['id_jurusan']; ?>">
                          <?= $j['nama_jurusan']; ?> - <?= $j['konsentrasi']; ?>
                      </option>
                  <?php endforeach; ?>
              </select>
              </div>

               <div class="form-group">
                 <label for="id_jurusan">Petugas</label>
              <select name="id_petugas" class="form-control">
                <?php foreach ($petugas as $p): ?>
                    <option value="<?= $p['id_petugas']; ?>"><?= $p['nama_petugas']; ?></option>
                <?php endforeach; ?>
              </select>
              </div>

              <div class="form-group">
                <label for="id_spp">SPP</label>
                <select id="id_spp" name="id_spp" class="form-control custom-select">
                  <?php foreach ($spp as $s): ?>
                    <option value="<?= $s['id_spp']; ?>"><?= $s['tahun'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <!-- PERBAIKAN TAMPILAN SEMESTER -->
              <div class="form-group">
                <label>Semester Aktif Tahun Ini</label>
                <div class="row">
                  <?php for ($i = 1; $i <= 8; $i++): ?>
                    <div class="col-md-6 col-lg-3 mb-2">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="semester<?= $i ?>" name="semester_aktif[]" value="<?= $i ?>">
                        <label class="custom-control-label" for="semester<?= $i ?>">Semester <?= $i ?></label>
                      </div>
                    </div>
                  <?php endfor; ?>
                </div>
                <small class="form-text text-muted">Pilih satu atau lebih semester yang aktif tahun ini.</small>
              </div>
              <!-- END PERBAIKAN -->
              
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-danger">Batal</a>
          <input type="submit" value="Tambah Data" class="btn btn-primary float-right">
        </div>
      </div>
</form>
<?= $this->include('tamplate/footer') ?>

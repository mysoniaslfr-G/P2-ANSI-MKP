<?= $this->include('tamplate/header') ?>
<form action="<?= base_url('/mahasiswa/update/' . $mahasiswa['id_mahasiswa']) ?>" method="post">
   <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Profil Mahasiswa</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" value="<?= $mahasiswa['nim'] ?>" required>
              </div>
              
              <div class="form-group">
                <label for="nama_mahasiswa">Nama Lengkap</label>
                <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" class="form-control" value="<?= $mahasiswa['nama_mahasiswa'] ?>" required>
              </div>
              
              <div class="form-group">
                <label for="alamat_mahasiswa">Alamat</label>
                <input type="text" id="alamat_mahasiswa" name="alamat_mahasiswa" class="form-control" value="<?= $mahasiswa['alamat_mahasiswa'] ?>" required>
              </div>

              <div class="form-group">
                <label for="no_telepon_mahasiswa">Nomor HP</label>
                <input type="text" id="no_telepon_mahasiswa" name="no_telepon_mahasiswa" class="form-control" value="<?= $mahasiswa['no_telepon_mahasiswa'] ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Edit Info Akademik</h3>
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
                    <option value="<?= $j['id_jurusan']; ?>" <?= $mahasiswa['id_jurusan'] == $j['id_jurusan'] ? 'selected' : '' ?>>
                      <?= $j['nama_jurusan'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="id_petugas">Petugas</label>
                <select id="id_petugas" name="id_petugas" class="form-control custom-select">
                  <?php foreach ($petugas as $p): ?>
                    <option value="<?= $p['id_petugas']; ?>" <?= (isset($mahasiswa['id_petugas']) && $mahasiswa['id_petugas'] == $p['id_petugas']) ? 'selected' : '' ?>>
                      <?= $p['nama_petugas']; ?>
                    </option>

                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="id_spp">SPP</label>
                <select id="id_spp" name="id_spp" class="form-control custom-select">
                  <?php foreach ($spp as $s): ?>
                    <option value="<?= $s['id_spp']; ?>" <?= $mahasiswa['id_spp'] == $s['id_spp'] ? 'selected' : '' ?>>
                      <?= $s['tahun'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>

       <div class="form-group">
    <label>Semester Aktif Tahun Ini</label>
    <div class="row">
        <?php for ($i = 1; $i <= 8; $i++): ?>
            <div class="col-md-6 col-lg-3 mb-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="semester<?= $i ?>"
                           name="semester_aktif[]"
                           value="Semester <?= $i ?>"
                           <?= in_array('Semester ' . $i, $semesterAktif) ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="semester<?= $i ?>">Semester <?= $i ?></label>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <small class="form-text text-muted">Pilih satu atau lebih semester yang aktif tahun ini.</small>
</div>


            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-danger">Batal</a>
          <input type="submit" value="Perbarui Data" class="btn btn-primary float-right">
        </div>
      </div>
</form>
<?= $this->include('tamplate/footer') ?>

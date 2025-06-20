<?= $this->include('tamplate/header') ?>

<div class="row">
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah SPP Mahasiswa</h3>
      </div>

      <form action="<?= base_url('/mahasiswa/saveSPP') ?>" method="post">
        <?= csrf_field() ?>
        <!-- ID Mahasiswa -->
        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa']; ?>">

        <div class="card-body">

          <!-- Pilih Tahun SPP -->
          <div class="form-group">
            <label for="id_spp">Tahun SPP</label>
            <select id="id_spp" name="id_spp" class="form-control custom-select" required>
              <?php foreach ($spp as $s): ?>
                <?php if ($s['id_jurusan'] == $mahasiswa['id_jurusan']): ?>
                  <option value="<?= $s['id_spp']; ?>"><?= esc($s['tahun']) ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Pilih Semester -->
          <div class="form-group">
            <label>Pilih Semester Aktif</label>
            <div class="row">
              <?php for ($i = 1; $i <= 8; $i++):
                $semester = "Semester $i";
                $sudahAda = in_array($semester, $sudah_terisi);
              ?>
                <div class="col-md-6 col-lg-3 mb-2">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="semester<?= $i ?>"
                           name="semester[]"
                           value="<?= $semester ?>"
                           <?= $sudahAda ? 'checked disabled' : '' ?>>
                    <label class="custom-control-label" for="semester<?= $i ?>">
                      <?= $semester ?> <?= $sudahAda ? '(sudah ditambahkan)' : '' ?>
                    </label>
                  </div>
                </div>
              <?php endfor; ?>
            </div>
            <small class="form-text text-muted">Semester yang sudah pernah ditambahkan tidak bisa dipilih ulang.</small>
          </div>

        </div>

        <div class="card-footer">
          <a href="<?= base_url('/mahasiswa/detail/' . $mahasiswa['id_mahasiswa']) ?>" class="btn btn-danger">Batal</a>
          <button type="submit" class="btn btn-primary float-right">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer') ?>

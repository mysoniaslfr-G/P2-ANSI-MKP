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
                <label for="id_jurusan">Prodi</label>
                <select id="id_jurusan" name="id_jurusan" class="form-control custom-select" required>
                  <option selected disabled>-- Pilih Prodi --</option>
                  <?php foreach ($jurusan as $j): ?>
                      <option value="<?= $j['id_jurusan']; ?>">
                          <?= esc($j['kode_prodi']); ?> - <?= esc($j['nama_prodi']); ?>
                      </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="id_spp">SPP</label>
                <select id="id_spp" name="id_spp" class="form-control custom-select" required>
                  <option selected disabled>-- Pilih Jurusan Terlebih Dahulu --</option>
                </select>
              </div>

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

<!-- SCRIPT DINAMIS DROPDOWN SPP -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const jurusanSelect = document.getElementById('id_jurusan');
  const sppSelect = document.getElementById('id_spp');

  jurusanSelect.addEventListener('change', function () {
    const idJurusan = this.value;
    sppSelect.innerHTML = '<option selected disabled>Loading...</option>';

    fetch('<?= base_url("getSppByJurusan") ?>/' + idJurusan)
      .then(response => response.json())
      .then(data => {
        sppSelect.innerHTML = '<option selected disabled>-- Pilih Tahun SPP --</option>';
        data.forEach(item => {
          const option = document.createElement('option');
          option.value = item.id_spp;
          option.textContent = item.tahun;
          sppSelect.appendChild(option);
        });
      })
      .catch(() => {
        sppSelect.innerHTML = '<option disabled selected>Gagal memuat data</option>';
      });
  });
});
</script>

<?= $this->include('tamplate/footer') ?>

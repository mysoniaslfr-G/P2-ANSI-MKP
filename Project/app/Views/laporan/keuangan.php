<?= $this->include('tamplate/header'); $no = 1; ?>

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-12">
      <!-- Card Utama -->
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="card-header">
          <!-- Tombol Cetak -->
            <a href="<?= base_url('laporan/pdf') . '?' . http_build_query($filter) ?>" target="_blank" class="btn btn-danger mr-2 float-right">
              <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="<?= base_url('laporan/excel') . '?' . http_build_query($filter) ?>" class="btn btn-success mr-2 float-right">
              <i class="fas fa-file-excel"></i> Excel
            </a>
          </div>

          <br>

          <!-- Filter -->
          <form method="get" action="<?= base_url('laporan') ?>" class="mb-4">
            <div class="form-row align-items-end">
              <div class="form-group col-md-3">
                <label for="jurusan">Pilih Prodi</label>
                <select name="jurusan" id="jurusan" class="form-control form-control-sm">
                  <option value="">-- Semua Prodi --</option>
                  <?php foreach ($jurusan as $item): ?>
                    <option value="<?= $item['id_jurusan'] ?>" <?= ($filter['jurusan'] ?? '') == $item['id_jurusan'] ? 'selected' : '' ?>>
                      <?= esc($item['nama_prodi']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="tahun">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="<?= esc($filter['tahun'] ?? '') ?>" class="form-control form-control-sm" placeholder="2025">
              </div>

              <div class="form-group col-md-1">
                <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>

          <!-- Tabel -->
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-hover table-striped">
              <thead class="thead-light text-center">
                <tr>
                  <th>#</th>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Prodi</th>
                  <th>Tahun</th>
                  <th>Semester</th>
                  <th>Nominal</th>
                  <th>Bayar</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (!empty($laporan) && is_array($laporan)) : ?>
                  <?php foreach ($laporan as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= esc($row['nim']) ?></td>
                      <td><?= esc($row['nama_mahasiswa']) ?></td>
                      <td><?= esc($row['nama_prodi']) ?></td>
                      <td><?= esc($row['tahun']) ?></td>
                      <td><?= esc($row['semester']) ?></td>
                      <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                      <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                      <td><?= esc($row['tgl_bayar']) ?: '-' ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <?php for ($i = 0; $i < 1; $i++): ?>
                    <tr class="text-center text-muted">
                      <?php for ($j = 1; $j <= 9; $j++): ?>
                        <td>-</td>
                      <?php endfor; ?>
                    </tr>
                  <?php endfor; ?>
                <?php endif; ?>
              </tbody>
              <tfoot class="thead-light text-center">
                <tr>
                  <th>#</th>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Prodi</th>
                  <th>Tahun</th>
                  <th>Semester</th>
                  <th>Nominal</th>
                  <th>Bayar</th>
                  <th>Tanggal</th>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer'); ?>

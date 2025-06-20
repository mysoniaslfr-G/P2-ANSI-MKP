<?= $this->include('tamplate/header') ?>

<div class="container-fluid">
  <div class="row">
    <!-- Profil Mahasiswa -->
    <div class="col-md-4">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="<?= base_url('public/img/' . (!empty($profil['gambar']) ? $profil['gambar'] : 'avatar2.png')) ?>"
                 alt="User profile picture">
          </div>
          <h3 class="profile-username text-center"><?= esc($profil['nama_mahasiswa']) ?></h3>
          <p class="text-muted text-center"><?= esc($profil['nama_prodi']) ?></p>
          <a href="<?= base_url('/pembayaran') ?>" class="btn btn-danger btn-block"><b>Kembali</b></a>
        </div>
      </div>
    </div>

    <!-- Detail Mahasiswa -->
    <div class="col-md-8">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Spp Aktif</b>
              <span class="badge badge-info float-right"><?= esc($profil['tahun']) . ' - Rp. ' . number_format($profil['nominal'], 0, ',', '.') ?></span>
            </li>
            <li class="list-group-item">
              <b>NIM</b>
              <span class="badge badge-info float-right"><?= esc($profil['nim']) ?></span>
            </li>
            <li class="list-group-item">
              <b>Alamat</b>
              <span class="badge badge-info float-right"><?= esc($profil['alamat_mahasiswa']) ?></span>
            </li>
            <li class="list-group-item">
              <b>Nomor HP</b>
              <span class="badge badge-info float-right"><?= esc($profil['no_telepon_mahasiswa']) ?></span>
            </li>
            <li class="list-group-item">
              <b>Kode Prodi</b>
              <span class="badge badge-info float-right"><?= esc($profil['kode_prodi']) ?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead class="text-center">
              <tr>
                <th>Tahun</th>
                <th>Semester</th>
                <th>Tgl Bayar</th>
                <th>Jumlah Bayar</th>
                <th>Petugas</th>
                <th>Bukti</th>
                <th>Status / Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pembayaran as $spp): ?>
                <?php
                  $total_bayar = 0;
                  if (!empty($spp['transaksi'])) {
                    foreach ($spp['transaksi'] as $trx) {
                      $total_bayar += $trx['jumlah_bayar'];
                    }
                  }
                  $sisa = $spp['nominal'] - $total_bayar;
                ?>
                <tr>
                  <td><?= esc($spp['tahun']) ?></td>
                  <td><?= esc($spp['semester']) ?></td>

                  <!-- Tanggal Bayar -->
                  <td>
                    <?php if (!empty($spp['transaksi'])): ?>
                      <?php foreach ($spp['transaksi'] as $trx): ?>
                        <div><?= esc($trx['tgl_bayar']) ?></div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <!-- Jumlah Bayar -->
                  <td>
                    <?php if (!empty($spp['transaksi'])): ?>
                      <?php foreach ($spp['transaksi'] as $trx): ?>
                        <div>Rp <?= number_format($trx['jumlah_bayar'], 0, ',', '.') ?></div>
                      <?php endforeach; ?>
                      <hr class="my-1">
                      <div><strong>Total: Rp <?= number_format($total_bayar, 0, ',', '.') ?></strong></div>
                      <div><strong class="<?= $sisa > 0 ? 'text-danger' : 'text-success' ?>">
                        Sisa: Rp <?= number_format($sisa, 0, ',', '.') ?>
                      </strong></div>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <!-- Petugas -->
                  <td>
                    <?php if (!empty($spp['transaksi'])): ?>
                      <?php foreach ($spp['transaksi'] as $trx): ?>
                        <div><?= esc($trx['nama_petugas'] ?? '-') ?></div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <!-- Bukti Bayar -->
                  <td>
                    <?php if (!empty($spp['transaksi'])): ?>
                      <?php foreach ($spp['transaksi'] as $trx): ?>
                        <div class="mb-1 text-center">
                          <?php if (!empty($trx['bukti_bayar']) && file_exists(FCPATH . 'uploads/' . $trx['bukti_bayar'])): ?>
                            <a href="<?= base_url('uploads/' . $trx['bukti_bayar']) ?>" target="_blank">
                              <img src="<?= base_url('uploads/' . $trx['bukti_bayar']) ?>" class="img-thumbnail" width="40">
                            </a>
                          <?php else: ?>
                            <span class="text-muted">Belum ada</span>
                          <?php endif; ?>
                        </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <!-- Status / Aksi -->
                  <td>
                    <?php if (!empty($spp['transaksi'])): ?>
                      <?php foreach ($spp['transaksi'] as $trx): ?>
                        <form action="<?= base_url('pembayaran/updateStatus/' . $trx['id_transaksi']) ?>" method="post" class="mb-2">
                          <?= csrf_field() ?>
                          <div class="input-group input-group-sm">
                            <select name="status" class="form-control">
                              <option value="pending" <?= $trx['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                              <option value="ditolak" <?= $trx['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                              <option value="valid" <?= $trx['status'] == 'valid' ? 'selected' : '' ?>>Valid</option>
                            </select>
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit"><i class="fas fa-sync-alt"></i></button>
                            </div>
                          </div>
                        </form>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="text-center">
              <tr>
                <th>Tahun</th>
                <th>Semester</th>
                <th>Tgl Bayar</th>
                <th>Jumlah Bayar</th>
                <th>Petugas</th>
                <th>Bukti</th>
                <th>Status / Aksi</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer') ?>

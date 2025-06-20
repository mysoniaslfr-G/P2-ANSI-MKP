<?= $this->include('tamplate/header') ?>

<div class="card card-primary card-outline">
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Tahun</th>
          <th>Semester</th>
          <th>Riwayat Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pembayaran as $spp): ?>
          <tr>
            <td><?= esc($spp['tahun']) ?></td>
            <td><?= esc($spp['semester']) ?></td>
            <td>
              <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width: 120px;">Tanggal</th>
                    <th>Jumlah</th>
                    <th>Petugas</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $totalBayar = 0;
                    $id_spp = $spp['id_spp'];
                    $transaksi = $spp['transaksi'] ?? [];
                  ?>

                  <?php foreach ($transaksi as $trx): ?>
                    <?php
                      $jumlah = (int)$trx['jumlah_bayar'];
                      $totalBayar += $jumlah;
                      $status = $trx['status'];
                      $badgeClass = match($status) {
                        'valid' => 'success',
                        'pending' => 'secondary',
                        'ditolak' => 'danger',
                        default => 'dark'
                      };
                    ?>
                    <tr>
                      <td><?= esc($trx['tgl_bayar'] ?? '-') ?></td>
                      <td>Rp <?= number_format($jumlah, 0, ',', '.') ?></td>
                      <td><?= esc($trx['nama_petugas'] ?? '-') ?></td>
                      <td>
                        <?php if (!empty($trx['bukti_bayar']) && file_exists(FCPATH . 'uploads/' . $trx['bukti_bayar'])): ?>
                          <a href="<?= base_url('uploads/' . $trx['bukti_bayar']) ?>" target="_blank">
                            <img src="<?= base_url('uploads/' . $trx['bukti_bayar']) ?>" class="img-thumbnail" width="50">
                          </a>
                        <?php else: ?>
                          <span class="text-danger">Belum Upload</span>
                        <?php endif; ?>
                      </td>
                      <td><span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span></td>
                      <td>
                        <?php if (empty($trx['bukti_bayar'])): ?>
                          <a href="<?= base_url('/pembayaran/bayar/' . $trx['id_transaksi']) ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-upload"></i> Upload
                          </a>
                        <?php elseif ($trx['status'] === 'ditolak'): ?>
                          <a href="<?= base_url('/pembayaran/edit/' . $trx['id_transaksi']) ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Ulangi Upload
                          </a>
                        <?php elseif ($trx['status'] === 'pending'): ?>
                          <span class="text-muted"><i class="fas fa-clock text-secondary"></i></span>
                        <?php elseif ($trx['status'] === 'valid'): ?>
                          <span class="text-muted"><i class="fas fa-check-circle text-success"></i></span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                  <tr class="table-light">
                    <td colspan="6" class="text-end fw-bold text-muted">
                      Total Dibayar: Rp <?= number_format($totalBayar, 0, ',', '.') ?><br>
                      Sisa: Rp <?= number_format((int)$spp['nominal'] - $totalBayar, 0, ',', '.') ?>
                    </td>
                  </tr>

                  <?php if ($totalBayar > 0 && $spp['nominal'] > $totalBayar): ?>
                    <tr>
                      <td colspan="6" class="text-end">
                        <a href="<?= base_url('pembayaran/sisa/' . $id_spp) ?>" class="btn btn-sm btn-danger">
                          <i class="fas fa-plus-circle"></i> Input Sisa
                        </a>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>Tahun</th>
          <th>Semester</th>
          <th>Riwayat Pembayaran</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?= $this->include('tamplate/footer') ?>

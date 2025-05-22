<?= $this->include('tamplate/header') ?>
        <div class="card card-primary card-outline">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Semester</th>
                  <th>Tgl Bayar</th>
                  <th>Tahun Bayar</th>
                  <th>Jumlah Bayar</th>
                  <th>Petugas</th>
                  <th>Bukti Bayar</th>
                  <th>Status/Aksi</th>
                </tr>
              </thead>
             <tbody>
              <?php foreach ($pembayaran as $spp): ?>
                <?php 
                  $jumlah_bayar = isset($spp['jumlah_bayar']) ? (int) $spp['jumlah_bayar'] : 0;
                  $nominal = isset($spp['nominal']) ? (int) $spp['nominal'] : 0;
                ?>
                <tr>
                  <td><?= esc($spp['semester']) ?></td>
                  <td><?= esc($spp['tgl_bayar'] ?? '-') ?></td>
                  <td><?= esc($spp['tahun_bayar'] ?? '-') ?></td>
                  <td>
                    Rp <?= number_format($jumlah_bayar, 0, ',', '.') ?>
                    <br>
                    <small class="text-muted">Sisa: Rp <?= number_format(max(0, $nominal - $jumlah_bayar), 0, ',', '.') ?></small>
                  </td>
                  <td><?= esc($spp['nama_petugas'] ?? '-') ?></td>
                  <td>
                  <?php if (!empty($spp['bukti_bayar']) && file_exists(FCPATH . 'uploads/' . $spp['bukti_bayar'])): ?>
                    <a href="<?= base_url('uploads/' . $spp['bukti_bayar']); ?>" target="_blank" rel="noopener noreferrer">
                      <img 
                        src="<?= base_url('uploads/' . $spp['bukti_bayar']); ?>" 
                        class="img-fluid img-thumbnail" 
                        alt="Bukti Bayar" 
                        width="80" 
                        style="object-fit: contain;" 
                        loading="lazy"
                      />
                    </a>
                  <?php else: ?>
                    <span class="text-danger">Belum upload</span>
                  <?php endif; ?>
                </td>


                  <td>
                    <a href="<?= base_url('/pembayaran/formBayar/' . $spp['id_pembayaran']) ?>" class="btn btn-primary btn-sm mt-1">
                      <i class="fas fa-edit"></i> Upload/Bayar
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
              <tfoot>
                <tr>
                  <th>Semester</th>
                  <th>Tgl Bayar</th>
                  <th>Tahun Bayar</th>
                  <th>Jumlah Bayar</th>
                  <th>Petugas</th>
                  <th>Bukti Bayar</th>
                  <th>Status/Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->

<?= $this->include('tamplate/footer') ?>
  

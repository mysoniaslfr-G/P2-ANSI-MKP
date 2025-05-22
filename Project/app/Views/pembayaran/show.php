<?= $this->include('tamplate/header') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="<?= base_url('public/img/' . (!empty($profil['gambar']) ? $profil['gambar'] : 'avatar2.png')) ?>">
                    </div>

                    <h3 class="profile-username text-center"><?= $profil['nama_mahasiswa']; ?></h3>
                    <p class="text-muted text-center"><?= $profil['nama_jurusan']; ?></p>

                    <a href="<?= base_url('/pembayaran') ?>" class="btn btn-danger btn-block"><b>Kembali</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Spp Aktif</b>
                            <label class="badge badge-info float-right">
                                <?= $profil['tahun'] . ' - Rp. ' . number_format($profil['nominal'], 0, ',', '.'); ?>
                            </label>
                        </li>
                        <li class="list-group-item">
                            <b>Nim</b>
                            <label class="badge badge-info float-right"><?= $profil['nim']; ?></label>
                        </li>
                        <li class="list-group-item">
                            <b>Alamat</b>
                            <label class="badge badge-info float-right"><?= $profil['alamat_mahasiswa']; ?></label>
                        </li>
                        <li class="list-group-item">
                            <b>Nomor HP</b>
                            <label class="badge badge-info float-right"><?= $profil['no_telepon_mahasiswa']; ?></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div> 
     </div>
    <!-- /.row -->

<div class="card card-primary card-outline">
  <div class="card-body">
   
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Tahun</th>
          <th>Semester</th>
          <th>Tgl Bayar</th>
          <th>Jumlah Bayar</th>
          <th>Petugas</th>
          <th>Bukti Bayar</th>
          <th>Status/Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pembayaran as $spp): ?>
          <tr>
            <td><?= esc($spp['tahun']) ?></td>
            <td><?= esc($spp['semester']) ?></td>
            <td><?= esc($spp['tgl_bayar']) ?></td>
            <td> 
                <?php
                    $bayar   = (int) $spp['jumlah_bayar'];
                    $nominal = (int) $spp['nominal'];
                ?>

                <?php if ($bayar === 0): ?>
                    <span class="badge badge-danger">Belum dibayar!</span>

                <?php elseif ($bayar < $nominal): ?>
                    <span class="badge badge-warning">
                        Sisa Rp. <?= number_format($nominal - $bayar, 0, ',', '.') ?>
                    </span>

                <?php elseif ($bayar === $nominal): ?>
                    <span class="badge badge-info">Lunas!</span>
                <?php endif; ?></td>
                        <td><?= esc($spp['nama_petugas']) ?? '-' ?></td>

            <!-- Kolom Bukti Bayar -->
            <td>
                <?php if (!empty($spp['bukti_bayar'])): ?>
                    <a href="<?= base_url('uploads/' . $spp['bukti_bayar']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                    <a href="<?= base_url('uploads/' . $spp['bukti_bayar']) ?>" download class="btn btn-sm btn-success">Download</a>
                <?php else: ?>
                    <span class="text-muted">Belum Ada</span>
                <?php endif ?>
            </td>

             <!-- Kolom Status / Aksi -->
            <td>
              <?php if ($spp['status_bayar'] === null): ?>
                <form action="<?= base_url('pembayaran/validasi/' . $spp['id_pembayaran']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status_bayar" value="Lunas">
                    <button type="submit" class="btn btn-warning btn-sm">Validasi</button>
                </form>

              <?php else: ?>
              <span class="badge badge-<?= $spp['status_bayar'] === 'Selesai' ? 'success' : 'warning' ?>">
                  <?= $spp['status_bayar'] === 'Selesai' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-hourglass-half"></i>' ?>
              </span>

                  <?= esc($spp['status_bayar']) ?>
                </span>
              <?php endif ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
      <tfoot>
        <tr>
          <th>Tahun</th>
          <th>Semester</th>
          <th>Tgl Bayar</th>
          <th>Jumlah Bayar</th>
          <th>Petugas</th>
          <th>Bukti Bayar</th>
          <th>Status/Aksi</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

                </div>
            </div>
      
   
</div><!-- /.container-fluid -->
<?= $this->include('tamplate/footer') ?>

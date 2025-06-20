<?= $this->include('tamplate/header') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="<?= base_url('public/img/' . (!empty($profil['gambar']) ? $profil['gambar'] : 'avatar2.png')) ?>">
                    </div>

                    <h3 class="profile-username text-center"><?= esc($profil['nama_mahasiswa']); ?></h3>

                    <p class="text-muted text-center"><?= esc($profil['kode_prodi']); ?> - <?= esc($profil['nama_prodi']); ?></p> <!-- Mengganti nama_jurusan dengan kode_prodi dan nama_prodi -->

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Spp Aktif</b>
                            <label class="badge badge-info float-right">
                                <?= esc($profil['tahun']) . ' - Rp. ' . number_format($profil['nominal'], 0, ',', '.'); ?>
                            </label>
                        </li>

                        <li class="list-group-item">
                            <b>NIM</b>
                            <label class="badge badge-info float-right">
                                <?= esc($profil['nim']); ?>
                            </label>
                        </li>

                        <li class="list-group-item">
                            <b>Nama Lengkap</b>
                            <label class="badge badge-info float-right">
                                <?= esc($profil['nama_mahasiswa']); ?>
                            </label>
                        </li>

                        <li class="list-group-item">
                            <b>Alamat</b>
                            <label class="badge badge-info float-right">
                                <?= esc($profil['alamat_mahasiswa']); ?>
                            </label>
                        </li>

                        <li class="list-group-item">
                            <b>Nomor HP</b>
                            <label class="badge badge-info float-right">
                                <?= esc($profil['no_telepon_mahasiswa']); ?>
                            </label>
                        </li>
                    </ul>

                    <div class="form-group">
                        <form action="<?= base_url('/mahasiswa/reset/' . $profil['id_user']); ?>" method="post">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Yakin ingin mereset password user ini?')"><b>Reset Password</b></button>
                        </form>
                    </div>

                    <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-danger btn-block"><b>Kembali</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4>Riwayat Pembayaran SPP</h4>
                    <a href="<?= base_url('/mahasiswa/add/' . $mahasiswa['id_mahasiswa']) ?>" class="btn btn-success float-right">
                        Tambah SPP
                    </a>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SPP</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
<tbody>
    <?php foreach ($pembayaran as $spp): ?>
        <tr>
            <td><?= esc($spp['tahun']) ?></td>
            <td><?= esc($spp['semester']) ?></td>
            <td>
                <?php
                    $bayar   = (int) $spp['jumlah_bayar'];
                    $nominal = (int) $spp['nominal'];
                ?>

                <?php if ($bayar === 0): ?>
                    <span class="badge badge-danger">Belum dibayar!</span>

                <?php elseif ($bayar < $nominal): ?>
                    <span class="badge badge-warning">
                        Belum lunas (Sisa Rp. <?= number_format($nominal - $bayar, 0, ',', '.') ?>)
                    </span>

                <?php else: ?>
                    <span class="badge badge-info">Lunas!</span>
                <?php endif; ?>
                <br>
                <small>Terbayar: Rp. <?= number_format($bayar, 0, ',', '.') ?></small>
            </td>

            <td>
                <?php
                    // Jika data transaksi disiapkan seperti di controller
                  if (!empty($spp['transaksi'])) {
    $petugasNames = []; // Array untuk menyimpan nama petugas

    foreach ($spp['transaksi'] as $trx) {
        $petugasNames[] = esc($trx['nama_petugas']); // Tambahkan nama petugas ke array
    }

    // Menghitung jumlah petugas
    $count = count($petugasNames);

    if ($count > 1) {
        // Jika ada lebih dari satu petugas, gabungkan dengan koma dan "dan"
        $lastPetugas = array_pop($petugasNames); // Ambil nama petugas terakhir
        echo implode(', ', $petugasNames) . ' dan ' . $lastPetugas; // Gabungkan dengan "dan"
    } elseif ($count === 1) {
        // Jika hanya ada satu petugas
        echo $petugasNames[0];
    } else {
        // Jika tidak ada petugas
        echo '-';
    }
} else {
    echo '-';
}

                ?>
            </td>
        </tr>
    <?php endforeach ?>
</tbody>

                        <tfoot>
                            <tr>
                                <th>SPP</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
<?= $this->include('tamplate/footer') ?>

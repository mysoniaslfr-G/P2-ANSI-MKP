<?= $this->include('tamplate/header') ?>

<?php
  $tab = $_GET['tab'] ?? 'profil'; // Default ke tab profil jika tidak ada parameter
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar Profil -->
    <div class="col-md-3">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="<?= base_url('public/img/' . (!empty($profil['gambar']) ? esc($profil['gambar']) : 'avatar2.png')) ?>"
               alt="User profile picture" width="150" height="150">

          <h3 class="profile-username font-weight-bold">
            <?= esc($profil['level'] === 'Mahasiswa'
                ? ($profil['nama_mahasiswa'] ?? '-')
                : ($profil['nama_petugas'] ?? '-')) ?>
          </h3>

          <p class="text-muted"><?= esc($profil['level']) ?></p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item d-flex justify-content-between">
              <b>Alamat</b>
              <span class="badge badge-info"><?= esc($profil['alamat_mahasiswa'] ?? ($profil['alamat_petugas'] ?? '-')) ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <b>Nomor HP</b>
              <span class="badge badge-info"><?= esc($profil['no_telepon_mahasiswa'] ?? ($profil['no_hp_petugas'] ?? '-')) ?></span>
            </li>

            <?php if ($profil['level'] === 'Mahasiswa'): ?>
              <li class="list-group-item d-flex justify-content-between">
                <b>Jurusan</b>
                <span class="badge badge-info"><?= esc($profil['nama_jurusan'] ?? '-') ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <b>Tahun SPP</b>
                <span class="badge badge-info"><?= esc($profil['tahun'] ?? '-') ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <b>Nominal SPP</b>
                <span class="badge badge-info">Rp<?= isset($profil['nominal']) ? number_format($profil['nominal'], 0, ',', '.') : '0' ?></span>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Konten Utama -->
    <div class="col-md-9">
      <div class="card">
        <!-- Nav Tabs -->
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link <?= $tab === 'profil' ? 'active' : '' ?>" href="?tab=profil">Foto Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $tab === 'settings' ? 'active' : '' ?>" href="?tab=settings">Settings</a>
            </li>
          </ul>
        </div>

        <!-- Tab Content -->
        <div class="card-body">
          <?php if ($tab === 'profil'): ?>
            <div class="tab-pane active">
              <?php if (isset($profil['id_user'])): ?>
                <form action="<?= base_url('/profil/update/' . $profil['id_user']) ?>" method="post" enctype="multipart/form-data">
                  <?= csrf_field() ?>
                  <div class="form-group">
                    <label for="gambar">Ganti Foto Profil</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*">
                      <label class="custom-file-label" for="gambar">Pilih file...</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                </form>
              <?php else: ?>
                <div class="alert alert-danger">
                  ID user tidak ditemukan. Silakan login kembali atau hubungi admin.
                </div>
              <?php endif; ?>
            </div>

          <?php elseif ($tab === 'settings'): ?>
            <div class="tab-pane active">
              <form class="form-horizontal" action="<?= base_url('/profil/update/' . $profil['id_user']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="nama"
                      value="<?= esc($profil['level'] === 'Mahasiswa' ? ($profil['nama_mahasiswa'] ?? '') : ($profil['nama_petugas'] ?? '')) ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="alamat" name="alamat"><?= esc($profil['alamat_mahasiswa'] ?? ($profil['alamat_petugas'] ?? '')) ?></textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputNoHp" class="col-sm-2 col-form-label">Nomor HP</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputNoHp" name="no_hp"
                      value="<?= esc($profil['no_telepon_mahasiswa'] ?? ($profil['no_hp_petugas'] ?? '')) ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          <?php endif; ?>
        </div> <!-- /.card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.col-md-9 -->
  </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<?= $this->include('tamplate/footer') ?>

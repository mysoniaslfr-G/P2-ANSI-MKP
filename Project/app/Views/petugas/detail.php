<?= $this->include('tamplate/header') ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="<?= base_url('public/img/' . (!empty($data['gambar']) ? $data['gambar'] : 'avatar2.png')) ?>"
                 alt="User profile picture">
          </div>

          <h3 class="profile-username text-center"><?= esc($data['username']) ?></h3>

          <p class="text-muted text-center">
            <?= esc($data['level']) ?>
          </p>

          <a href="<?= base_url('/petugas') ?>" class="btn btn-warning btn-block"><b>Kembali</b></a>
            <a href="<?= base_url('petugas/reset/' . $data['id_user']) ?>" 
                class="btn btn-info btn-block" 
                onclick="return confirm('Yakin ingin mereset password user ini?')">
                Reset Password
            </a>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="card card-primary card-outline">
        <div class="card-header">
            <h4>Profil</h4>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="">Nama Lengkap : </label>
                <label for="" class="badge badge-info"><?= $data['nama_petugas']; ?></label>
            </div>

           <div class="form-group">
                <label for="">Nomor Hp : </label>
                <label for="" class="badge badge-success"><?= $data['no_hp_petugas']; ?></label>
            </div>

            <div class="form-group">
                <label for="">Alamat : </label>
                <label for="" class="badge badge-warning"><?= $data['alamat_petugas']; ?></label>
            </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?= $this->include('tamplate/footer') ?>

<?= $this->include('tamplate/header') ?>

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/prodi/store'); ?>" method="post">
                <?= csrf_field() ?>

                 <div class="form-group">
                    <label for="kode_prodi">Kode Prodi</label> <!-- Mengganti konsentrasi menjadi kode_prodi -->
                    <input type="text" name="kode_prodi" class="form-control" required> <!-- Mengganti konsentrasi menjadi kode_prodi -->
                </div>

                <div class="form-group">
                    <label for="nama_prodi">Nama Prodi</label> <!-- Mengganti nama_jurusan menjadi nama_prodi -->
                    <input type="text" name="nama_prodi" class="form-control" required> <!-- Mengganti nama_jurusan menjadi nama_prodi -->
                </div>

                <div class="form-group">
                    <a href="<?= base_url('/prodi') ?>" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('tamplate/footer') ?>

<?= $this->include('tamplate/header') ?>

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/jurusan/store'); ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nama_jurusan">Nama Jurusan</label>
                    <input type="text" name="nama_jurusan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="konsentrasi">Konsentrasi</label>
                    <input type="text" name="konsentrasi" class="form-control" required>
                </div>

                <div class="form-group">
                    <a href="<?= base_url('/jurusan') ?>" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('tamplate/footer') ?>

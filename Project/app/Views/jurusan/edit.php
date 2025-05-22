<?= $this->include('tamplate/header') ?>

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('jurusan/update/' . $jurusan['id_jurusan']); ?>" method="post">
                <?= csrf_field() ?> <!-- CSRF Token -->

                <!-- Menampilkan Error jika ada -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Menampilkan Success atau Error Alert -->
                <?php if (session()->getFlashdata('alert')): ?>
                    <div class="alert alert-<?= session()->getFlashdata('alert')[0] ?>">
                        <?= session()->getFlashdata('alert')[1] ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama_jurusan">Nama Jurusan</label>
                    <input type="text" id="nama_jurusan" name="nama_jurusan" class="form-control" 
                           value="<?= esc($jurusan['nama_jurusan']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="konsentrasi">Konsentrasi</label>
                    <input type="text" id="konsentrasi" name="konsentrasi" class="form-control" 
                           value="<?= esc($jurusan['konsentrasi']) ?>" required>
                </div>

                <div class="form-group">
                    <a href="<?= base_url('/jurusan') ?>" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('tamplate/footer') ?>

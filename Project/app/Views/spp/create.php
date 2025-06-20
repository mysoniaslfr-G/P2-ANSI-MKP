<?= $this->include('tamplate/header') ?>

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/spp/store'); ?>" method="post">
                <?= csrf_field() ?> <!-- CSRF Token untuk menghindari CSRF attack -->

               <div class="form-group">
                    <label for="id_jurusan">Kode Prodi</label>
                    <select id="id_jurusan" name="id_jurusan" class="form-control" required>
                        <option value="">Pilih Kode Prodi</option>
                        <?php if (isset($jurusan) && is_array($jurusan)) : ?>
                            <?php foreach ($jurusan as $row): ?>
                                <option value="<?= esc($row['id_jurusan']) ?>">
                                    <?= esc($row['kode_prodi']) ?> - <?= esc($row['nama_prodi']) ?> <!-- Menambahkan nama prodi -->
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Tidak ada jurusan.</option>
                        <?php endif; ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" id="tahun" name="tahun" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nominal">Nominal</label>
                    <input type="number" id="nominal" name="nominal" class="form-control" required>
                </div>

                <div class="form-group">
                    <a href="<?= base_url('/spp') ?>" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<?= $this->include('tamplate/footer') ?>

<?= $this->include('tamplate/header') ?>

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/spp/store'); ?>" method="post">
                <?= csrf_field() ?> <!-- CSRF Token untuk menghindari CSRF attack -->

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

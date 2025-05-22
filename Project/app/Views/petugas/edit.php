<?= $this->include('tamplate/header') ?>

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <form action="<?= base_url('/petugas/update/' . $petugas['id_user']); ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" id="level" class="form-control">
                        <option value="1" <?= $petugas['level'] == 1 ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= $petugas['level'] == 2 ? 'selected' : '' ?>>Petugas</option>
                    </select>
                </div>

                <div class="form-group">
                    <a href="<?= base_url('/petugas') ?>" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<?= $this->include('tamplate/footer') ?>

<?= $this->include('tamplate/header'); $no=1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="<?= base_url('/spp/create') ?>" class="btn btn-primary float-right">Tambah Data</a>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Tahun</th>
                <th>Nominal</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($spp) && is_array($spp)) : ?>
                <?php foreach ($spp as $row): ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= esc($row['tahun']) ?></td>
                    <td>Rp<?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    <td>
                      <a href="<?= base_url('/spp/edit/' . $row['id_spp']) ?>" class="btn btn-warning btn-sm">Edit</a>
                      <form action="<?= base_url('/spp/delete/' . $row['id_spp']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    </td>
                  </tr>
                  <?php $no++; ?>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="4">Tidak ada data.</td></tr>
              <?php endif ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Tahun</th>
                <th>Nominal</th>
                <th>AKSI</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer'); ?>

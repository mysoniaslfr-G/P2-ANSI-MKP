<?= $this->include('tamplate/header'); $no = 1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="<?= base_url('/petugas/create') ?>" class="btn btn-primary float-right">Tambah Data</a>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Level Petugas</th>
                <th>Photo</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($petugas) && is_array($petugas)) : ?>
                <?php foreach ($petugas as $row): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($row['nama_petugas']) ?></td>
                    <td><?= esc($row['level']) ?></td>
                    <td>
                      <img src="<?= base_url('public/img/' . (!empty($row['gambar']) ? $row['gambar'] : 'avatar2.png')) ?>" width="50" class="img-circle elevation-2">
                    </td>
                    <td>

                    <a href="<?= base_url('/petugas/detail/' . $row['id_user']) ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="<?= base_url('/petugas/edit/' . $row['id_user']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?= base_url('/petugas/delete/' . $row['id_user']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>

                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center">Tidak ada data petugas.</td>
                </tr>
              <?php endif ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Level Petugas</th>
                <th>Photo</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->include('tamplate/footer'); ?>

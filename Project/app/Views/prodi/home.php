<?= $this->include('tamplate/header'); $no = 1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
          <a href="<?= base_url('/prodi/create') ?>" class="btn btn-primary float-right">Tambah Data</a>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                   <th>Kode Prodi</th> <!-- Mengganti Konsentrasi menjadi Kode Prodi -->
                <th>Nama Prodi</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($jurusan) && is_array($jurusan)) : ?>
                <?php foreach ($jurusan as $row): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($row['kode_prodi']) ?></td> <!-- Mengganti konsentrasi menjadi kode_prodi -->
                    <td><?= esc($row['nama_prodi']) ?></td> <!-- Mengganti nama_jurusan menjadi nama_prodi -->
                 
                    <td>
                      <a href="<?= base_url('/prodi/edit/' . $row['id_jurusan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                      <form action="<?= base_url('/prodi/delete/' . $row['id_jurusan']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>
              <?php endif ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                 <th>Kode Prodi</th> <!-- Mengganti Konsentrasi menjadi Kode Prodi -->
                <th>Nama Prodi</th>
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

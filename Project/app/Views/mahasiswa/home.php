<?= $this->include('tamplate/header'); ?>
<?php $no = 1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="<?= base_url('/mahasiswa/create') ?>" class="btn btn-primary float-right">Tambah Data</a>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Kode Prodi</th> <!-- Kolom baru kode prodi sebelum prodi -->
                <th>Prodi</th> <!-- Menghapus konsentrasi, menampilkan prodi -->
                <th>Photo</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $m): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= esc($m['nim']); ?></td>
                  <td><?= esc($m['nama_mahasiswa']); ?></td>
                  <td><?= esc($m['kode_prodi']) ?></td> <!-- Menampilkan kode prodi -->
                  <td><?= esc($m['nama_prodi']) ?></td> <!-- Menampilkan prodi -->
                  <td>
                     <img src="<?= base_url('public/img/' . (!empty($m['gambar']) ? $m['gambar'] : 'avatar2.png')) ?>" width="60" class="img-circle elevation-2">
                  </td>
                  <td>
                    <a href="<?= base_url('/mahasiswa/detail/' . $m['id_mahasiswa']) ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="<?= base_url('/mahasiswa/edit/' . $m['id_mahasiswa']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('/mahasiswa/delete/' . $m['id_mahasiswa']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Kode Prodi</th>
                <th>Prodi</th>
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
<?= $this->include('tamplate/header'); $no = 1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Tahun</th>
                <th>Semester</th>
                <th>Nominal SPP</th>
                <th>Jumlah Bayar</th>
                <th>Tanggal Bayar</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($laporan) && is_array($laporan)) : ?>
                <?php foreach ($laporan as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nim']) ?></td>
                    <td><?= esc($row['nama_mahasiswa']) ?></td>
                    <td><?= esc($row['nama_jurusan']) ?></td>
                    <td><?= esc($row['tahun']) ?></td>
                    <td><?= esc($row['semester']) ?></td>
                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                    <td><?= $row['tanggal_bayar'] ?? '-' ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="8" class="text-center">Tidak ada data pembayaran.</td></tr>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Semester</th>
                <th>Nominal SPP</th>
                <th>Jumlah Bayar</th>
                <th>Tanggal Bayar</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<?= $this->include('tamplate/footer'); ?>

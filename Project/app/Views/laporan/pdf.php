<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #000;
      padding: 6px 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    h2 {
      text-align: center;
    }

    .info {
      margin-top: 20px;
      font-size: 13px;
    }
  </style>
</head>
<body>

  <h2>Laporan Pembayaran SPP</h2>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Kode prodi</th>
        <th>Nama Prodi</th>
        <th>Tahun</th>
        <th>Semester</th>
        <th>Nominal SPP</th>
        <th>Jumlah Bayar</th>
        <th>Tanggal Bayar</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($laporan as $row): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= esc($row['nim']) ?></td>
          <td><?= esc($row['nama_mahasiswa']) ?></td>
           <td><?= esc($row['kode_prodi']) ?></td>
          <td><?= esc($row['nama_prodi']) ?></td> 
          <td><?= esc($row['tahun']) ?></td>
          <td><?= esc($row['semester']) ?></td>
          <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
          <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
          <td><?= $row['tgl_bayar'] ?? '-' ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>

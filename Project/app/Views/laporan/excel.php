<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>

   <h2>
    Laporan Pembayaran SPP
    - <?= !empty($nama_prodi) ? esc($nama_prodi) : 'Semua Program Studi' ?>
    </h2>

    <h4>
        Tahun: <?= !empty($filter['tahun']) ? esc($filter['tahun']) : 'Semua Tahun' ?>
    </h4>

    <table>
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
            <?php $no = 1; foreach ($laporan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nim']) ?></td>
                    <td><?= esc($row['nama_mahasiswa']) ?></td>
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

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jun 2025 pada 14.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mkp_ci4`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `kode_prodi` varchar(255) DEFAULT NULL,
  `nama_prodi` varchar(255) NOT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`kode_prodi`, `nama_prodi`, `id_jurusan`) VALUES
('FTIK201', 'Ilmu Komputer', 6),
('FTIK202', 'Teknik Sipil', 7),
('FK301', 'Ilmu Gizi', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `nim` varchar(10) DEFAULT NULL,
  `nama_mahasiswa` varchar(225) NOT NULL,
  `alamat_mahasiswa` text DEFAULT NULL,
  `no_telepon_mahasiswa` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `id_user`, `id_spp`, `id_jurusan`, `nim`, `nama_mahasiswa`, `alamat_mahasiswa`, `no_telepon_mahasiswa`) VALUES
(27, 39, 6, 6, 'B02220021', 'Nur Anisa', 'Sape', '99999'),
(40, 3, 9, 6, 'B02220125', 'Fera Febrianti', 'Rabangodu Utara', '11111'),
(43, 42, 8, 8, 'C02220001', 'Umratul Fatiha', 'Kel. Nungga', '22222');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `semester` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_mahasiswa`, `id_spp`, `semester`) VALUES
(5, 40, 9, 'Semester 5'),
(6, 40, 9, 'Semester 6'),
(18, 27, 6, 'Semester 3'),
(19, 27, 6, 'Semester 4'),
(20, 43, 8, 'Semester 5'),
(21, 43, 8, 'Semester 6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_petugas` varchar(125) DEFAULT NULL,
  `alamat_petugas` text DEFAULT NULL,
  `no_hp_petugas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `id_user`, `nama_petugas`, `alamat_petugas`, `no_hp_petugas`) VALUES
(8, 11, 'Dina', 'Yogyakarta', '22222'),
(9, 23, 'Fitria', 'jakarta', '90909'),
(10, 1, 'Sonia Salfira', 'Kel. Penana\'e', '081233444223'),
(11, 2, 'zumhur ', 'Rabangodu Utara', '083444555666');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spp`
--

CREATE TABLE `spp` (
  `id_spp` int(11) NOT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  `tahun` varchar(10) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spp`
--

INSERT INTO `spp` (`id_spp`, `id_jurusan`, `tahun`, `nominal`) VALUES
(6, 6, '2023', 2700000),
(7, 7, '2025', 2000000),
(8, 8, '2025', 2500000),
(9, 6, '2025', 2700000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status` enum('pending','valid','ditolak') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pembayaran`, `id_petugas`, `tgl_bayar`, `jumlah_bayar`, `bukti_bayar`, `status`) VALUES
(5, 5, 11, '2025-06-14', 1000000, '1749908121_9164c88b1ffa3a3dcb12.jpg', 'valid'),
(6, 6, 39, '2025-06-15', 700000, '1749972866_3c753d5c04c2f663781b.png', 'pending'),
(14, 18, 11, '2025-06-15', 2000000, '1749970149_4d75cb5a2e695285a42d.jpg', 'pending'),
(15, 19, 11, '2025-06-15', 600000, '1749975482_f39574e8e40a63522c4d.jpg', 'valid'),
(16, 20, 11, '2025-06-19', 1000000, '1750301879_24e0a32f782c7f5b3558.png', 'ditolak'),
(17, 21, 1, NULL, 0, NULL, 'pending'),
(21, 5, NULL, '2025-06-15', 700000, '1749973662_05a7f19608ad1a10ffe8.jpg', 'pending'),
(22, 5, NULL, '2025-06-15', 1000000, '1749973707_7dd30e89d1271e8e80a1.png', 'pending'),
(23, 18, 1, '2025-06-15', 700000, '1749973782_b814f882dd9f71b83734.jpg', 'ditolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(125) DEFAULT NULL,
  `level` enum('Admin','Petugas','Mahasiswa') DEFAULT NULL,
  `gambar` varchar(125) DEFAULT NULL,
  `remember_token` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `level`, `gambar`, `remember_token`) VALUES
(1, 'sonia', '$2y$10$pZVGX.NGGiobjUIJQRC0oOaPA0jsC87m7gRRdZlgGCY0WFuN6Ltru', 'Admin', '1747809269_cf720c55c0b136ed529e.jpg', NULL),
(2, 'zumhur', '$2y$10$TJkdXQ5tdNMlBUEU8RQ7gOG/beSuT.a4jiIjvNyypVfLJ5EqxOOIe', 'Petugas', '1747840795_4911959ba79931700303.png', NULL),
(3, 'B02220125', '$2y$10$nOQFgn2X9W0xGjZk2eB4quf2IqupAVB5Reh7VDv.RxL7ckRA0pPgG', 'Mahasiswa', '1748011075_cbee80feb76b636f7bca.jpg', NULL),
(11, 'Dina', '$2y$10$bL.Ldd3Rwdr7s20lAsMwG.zDOrjxTWUzvskWZ03bfZk9gKEGYAQSS', 'Petugas', 'avatar3.png', NULL),
(23, 'Fitria', '$2y$10$i7kK9R73wLEe0zh3UdNZw..xZlLS00KhWbZ.vbTM55udhVCVnuFyC', 'Petugas', 'avatar3.png', NULL),
(39, 'B02220021', '$2y$10$ZT1kNzsdsDDgTOrgl8TJ/et.UlcKdB9kMwmgTkwG93ZvQYN3WBrIK', 'Mahasiswa', 'avatar2.png', NULL),
(42, 'C02220001', '$2y$10$rwaaZY/87lmzKzdTDjeDq.7dyh4EMZEsi3RXRS2nW9Ew6kTqbRdyC', 'Mahasiswa', 'avatar2.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `no_telepon_mahasiswa` (`no_telepon_mahasiswa`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_spp` (`id_spp`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `fk_mahasiswa` (`id_mahasiswa`),
  ADD KEY `fk_spp` (`id_spp`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`),
  ADD KEY `fk_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pembayaran` (`id_pembayaran`),
  ADD KEY `fk_transaksi_petugas` (`id_petugas`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `spp`
--
ALTER TABLE `spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `mahasiswa_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`) ON DELETE CASCADE,
  ADD CONSTRAINT `mahasiswa_ibfk_3` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_spp` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD CONSTRAINT `petugas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `spp`
--
ALTER TABLE `spp`
  ADD CONSTRAINT `fk_jurusan` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

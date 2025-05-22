-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2025 pada 17.37
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
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(25) DEFAULT NULL,
  `konsentrasi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `konsentrasi`) VALUES
(6, 'Ilmu Komputer', 'Pemrograman'),
(7, 'Ilmu Komputer', 'Data Sains');

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
(27, 39, 6, 6, '12345', 'Nur Anisa', 'Sape', '99999'),
(40, 3, 7, 6, '123', 'Fera Febrianti', 'Rabangodu Utara', '11111'),
(43, 42, 6, 6, '1234', 'Maria Ulfa', 'Sape', '22222');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status_bayar` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_petugas`, `id_spp`, `id_mahasiswa`, `tgl_bayar`, `semester`, `jumlah_bayar`, `bukti_bayar`, `status_bayar`) VALUES
(126, 9, 6, 27, NULL, 'Semester 1', NULL, NULL, NULL),
(127, 9, 6, 27, NULL, 'Semester 2', NULL, NULL, NULL),
(133, 8, 7, 27, NULL, 'Semester 3', NULL, NULL, NULL),
(134, 8, 7, 27, NULL, 'Semester 4', NULL, NULL, NULL);

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
  `tahun` varchar(10) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spp`
--

INSERT INTO `spp` (`id_spp`, `tahun`, `nominal`) VALUES
(6, '2023', 2700000),
(7, '2025', 2000000);

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
(1, 'sonia', '$2y$10$pZVGX.NGGiobjUIJQRC0oOaPA0jsC87m7gRRdZlgGCY0WFuN6Ltru', 'Admin', '1747809269_cf720c55c0b136ed529e.jpg', 'af6636b48c20fafd8bd77833d72466b4b641605a13a1d9f73757cafabe30c5ab'),
(2, 'p1', '$2y$10$8vrcYasqP13xBS0I6.pn8.mAhB5wbfHWncMAy57vruVuaQtbSdkHe', 'Petugas', '1747840795_4911959ba79931700303.png', NULL),
(3, '123', '$2y$10$pZVGX.NGGiobjUIJQRC0oOaPA0jsC87m7gRRdZlgGCY0WFuN6Ltru', 'Mahasiswa', NULL, NULL),
(11, 'p2', '$2y$10$kpPds5oaJ108Gc032YRRleNWvawNr7mWWo3Euzk631FOZMAxqsYEy', 'Petugas', 'avatar3.png', NULL),
(23, 'p3', '$2y$10$Hk/XfkZ0lnPWUJ5eNmt6HOiDNrsv5JUEc7ar4wwANhH4j/cf8PmW6', 'Petugas', 'avatar3.png', NULL),
(39, '12345', '$2y$10$gtdUXrz8HWCNQisyrnmKe.Ps7JKl48/rKPOnOiy7cNZzByjqQPdvu', 'Mahasiswa', 'avatar2.png', NULL),
(42, '1234', '$2y$10$RPDDnUsAHx1Zew7R3t6BWe4YaM.WQo9A.6vqqRnD3oVlVoLq/FRgm', 'Mahasiswa', 'avatar2.png', NULL),
(43, '1234', '$2y$10$j6YpgWO4dfXhbEHmLSfkReRpEQWorpyF8oeFJPXw/y6yJO2p0V1L.', 'Mahasiswa', 'avatar2.png', NULL),
(44, '1234', '$2y$10$4iEV.c1Vlf9pOEMcbHPT7u96dN7gzCBUgBSyxzJuq3mZO.egzWjyq', 'Mahasiswa', 'avatar2.png', NULL),
(45, '12', '$2y$10$h//zYHm8coxTy5TTvptD3uCOu/UEPrEXRQGZzq08A8wQkpUf/17/e', 'Mahasiswa', 'avatar2.png', NULL);

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
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_spp` (`id_spp`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

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
  ADD PRIMARY KEY (`id_spp`);

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
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `spp`
--
ALTER TABLE `spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`),
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`);

--
-- Ketidakleluasaan untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD CONSTRAINT `petugas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

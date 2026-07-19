-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jul 2026 pada 06.58
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
-- Database: `rentgo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `total_hari` int(11) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `diskon` int(11) DEFAULT 0,
  `status` enum('Menunggu Pembayaran','Menunggu Verifikasi','Sedang Disewa','Selesai','Dibatalkan') DEFAULT 'Menunggu Pembayaran',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `mobil_id`, `tanggal_mulai`, `tanggal_selesai`, `total_hari`, `total_harga`, `diskon`, `status`, `created_at`) VALUES
(2, 9, 3, '2026-06-06', '2026-06-07', 1, 1500000.00, 0, 'Selesai', '2026-06-05 19:57:59'),
(3, 9, 2, '2026-06-06', '2026-06-07', 1, 550000.00, 0, 'Selesai', '2026-06-05 20:51:22'),
(4, 10, 3, '2026-06-07', '2026-06-08', 1, 1500000.00, 0, 'Selesai', '2026-06-07 16:08:13'),
(5, 1, 3, '2026-06-07', '2026-06-08', 1, 1500000.00, 0, 'Selesai', '2026-06-07 16:39:41'),
(6, 10, 3, '2026-06-08', '2026-06-09', 1, 1500000.00, 0, 'Selesai', '2026-06-07 16:43:03'),
(23, 1, 3, '2026-07-19', '2026-07-21', 2, 3000000.00, 0, 'Selesai', '2026-07-18 17:36:51'),
(24, 13, 3, '2026-07-19', '2026-07-21', 2, 3000000.00, 0, 'Selesai', '2026-07-18 17:39:05'),
(25, 13, 3, '2026-07-19', '2026-07-22', 3, 4050000.00, 450000, 'Selesai', '2026-07-18 17:40:21'),
(26, 13, 3, '2026-07-19', '2026-07-20', 1, 1500000.00, 0, '', '2026-07-18 17:41:53'),
(27, 13, 3, '2026-07-19', '2026-07-20', 1, 1500000.00, 0, '', '2026-07-18 21:11:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `nama_mobil` varchar(100) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `tahun` year(4) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `transmisi` enum('Manual','Matic') NOT NULL,
  `bahan_bakar` varchar(50) DEFAULT NULL,
  `kapasitas_penumpang` int(11) DEFAULT NULL,
  `harga_per_hari` decimal(12,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('Tersedia','Disewa','Maintenance') DEFAULT 'Tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id`, `nama_mobil`, `merk`, `tahun`, `plat_nomor`, `warna`, `transmisi`, `bahan_bakar`, `kapasitas_penumpang`, `harga_per_hari`, `deskripsi`, `gambar`, `status`, `created_at`) VALUES
(1, 'Avanza', 'Toyota', '2023', 'BK 805 RGO', 'Putih', 'Manual', 'Bensin', 7, 400000.00, NULL, 'mobil_6a5c32fa02c53.jpg', 'Tersedia', '2026-06-02 16:57:48'),
(2, 'Innova Reborn', 'Toyota', '2024', 'BK 805 NOV', 'Hitam', 'Matic', 'Diesel', 7, 550000.00, NULL, 'mobil_6a5c33110cff0.jpg', 'Tersedia', '2026-06-02 16:57:48'),
(3, 'Alphard', 'Toyota', '2025', 'BK 805 VIP', 'Hitam', 'Matic', 'Bensin', 7, 1500000.00, NULL, 'mobil_6a5c331f4fbd2.jpg', 'Tersedia', '2026-06-02 20:02:17'),
(5, 'Fortuner GR Sport 2.8', 'Toyota', '2024', 'BK 805 MDA', 'Hitam', 'Matic', 'diesel', 7, 1300000.00, NULL, 'mobil_6a5c335198b15.jpg', 'Tersedia', '2026-07-19 00:01:32'),
(7, 'Xpander', 'Mitsubishi', '2024', 'BK 805 XPD', 'Putih', 'Manual', 'Bensin', 7, 500000.00, NULL, 'mobil_6a5c36dc063f0.jpg', 'Tersedia', '2026-07-19 02:30:30'),
(8, 'BR-V', 'Honda', '2024', 'BK 805 BRV', 'Putih', 'Matic', 'Bensin', 7, 550000.00, NULL, 'mobil_6a5c3c889e52a.jpg', 'Tersedia', '2026-07-19 02:34:50'),
(9, 'GT86', 'Toyota', '2025', 'BK 805 GT', 'Biru', 'Manual', 'Bensin', 4, 1800000.00, NULL, 'mobil_6a5c3c98c71b4.jpg', 'Tersedia', '2026-07-19 02:38:35'),
(10, 'BMW M5 Competition', 'BMW', '2025', 'BK 805 BMW', 'Hitam', 'Matic', 'Bensin', 5, 2200000.00, NULL, 'mobil_6a5c3cb208d86.jpg', 'Tersedia', '2026-07-19 02:43:19'),
(11, 'Mercedes-Benz C200 AMG Line', 'Mercedes-Benz', '2025', 'BK 805 MB', 'Hitam', 'Matic', 'Bensin', 5, 2500000.00, NULL, 'mobil_6a5c3cc91f4cf.jpg', 'Tersedia', '2026-07-19 02:46:39'),
(12, 'Hiace Premio Luxury', 'Toyota', '2025', 'BK 805 HC', 'Putih', 'Manual', 'Diesel', 14, 5000000.00, NULL, 'mobil_6a5c3dd6653a1.jpg', 'Tersedia', '2026-07-19 02:54:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `jumlah_bayar` decimal(12,2) DEFAULT NULL,
  `status` enum('Menunggu Verifikasi','Diterima','Ditolak') DEFAULT 'Menunggu Verifikasi',
  `tanggal_bayar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `booking_id`, `metode_pembayaran`, `bukti_transfer`, `jumlah_bayar`, `status`, `tanggal_bayar`) VALUES
(2, 2, 'Transfer BRI', '1780689824_alphard.jpg', 1500000.00, 'Diterima', '2026-06-05 20:03:44'),
(3, 3, 'Transfer BRI', '1780692764_innova.jpg', 550000.00, 'Diterima', '2026-06-05 20:52:44'),
(4, 4, 'Transfer BRI', '1780848576_alphard.jpg', 1500000.00, 'Diterima', '2026-06-07 16:09:36'),
(5, 5, 'Transfer BRI', '1780850413_alphard.jpg', 1500000.00, 'Diterima', '2026-06-07 16:40:13'),
(6, 6, 'Transfer BRI', '1780851286_alphard.jpg', 1500000.00, 'Diterima', '2026-06-07 16:54:46'),
(14, 23, 'Transfer BRI', 'PAY-23-6a5bb9e1a2039.png', 3000000.00, 'Diterima', '2026-07-18 17:37:37'),
(15, 24, 'Transfer BRI', 'PAY-24-6a5bba4c916d6.png', 3000000.00, 'Diterima', '2026-07-18 17:39:24'),
(16, 25, 'Transfer BRI', 'PAY-25-6a5bbaa057a5c.png', 4050000.00, 'Diterima', '2026-07-18 17:40:48'),
(17, 26, 'Transfer BRI', 'PAY-26-6a5bbaed9f621.png', 1500000.00, 'Ditolak', '2026-07-18 17:42:05'),
(18, 27, 'Transfer BRI', 'PAY-27-6a5becf096238.png', 1500000.00, 'Ditolak', '2026-07-18 21:15:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `kode_promo` varchar(50) DEFAULT NULL,
  `nama_promo` varchar(100) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `review`
--

INSERT INTO `review` (`id`, `booking_id`, `user_id`, `mobil_id`, `rating`, `komentar`, `created_at`) VALUES
(1, 7, 10, 3, 5, 'ANJAYY KEREN BEUTZZZZ', '2026-06-16 22:12:02'),
(2, 12, 11, 2, 5, 'MOBIL NYAMAN DAN BERSIH\r\n', '2026-06-23 10:00:58'),
(3, 25, 13, 3, 5, 'mobilnya terawat dan nyaman', '2026-07-18 21:20:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `no_hp`, `alamat`, `role`, `created_at`) VALUES
(1, 'BOSSS', 'BOSSS@gmail.com', '7a674153c63cff1ad7f0e261c369ab2c', 'mau tau aje lu', 'SERLOK', 'admin', '2026-06-02 16:57:22'),
(2, '$nama', '$email', '$password', '', '', 'user', '2026-06-02 18:49:47'),
(6, 'kicau', 'kicau@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, 'user', '2026-06-02 19:12:12'),
(7, 'test', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, 'user', '2026-06-02 19:18:31'),
(8, 'rizal', 'rizal@gmail.com', 'ed6b202e937c3e83cfc9f9ea1aedbe0e', NULL, NULL, 'user', '2026-06-02 22:49:39'),
(9, 'iyawak', 'iyawak@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, 'user', '2026-06-05 19:44:52'),
(10, 'okela', 'okela@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '87654322', 'JALAN JALAN', 'user', '2026-06-07 16:06:44'),
(11, 'slebew', 'slebew@gmail.com', '202cb962ac59075b964b07152d234b70', '0822', 'mana aja la', 'user', '2026-06-23 07:42:50'),
(12, 'rexy', 'rexy@gmail.com', '202cb962ac59075b964b07152d234b70', '0812345678', 'jalan mana aja', 'user', '2026-07-13 17:49:22'),
(13, 'woii', 'woii@gmail.com', '202cb962ac59075b964b07152d234b70', 'mau tau aje lu', 'mana aja la', 'user', '2026-07-18 16:58:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mobil_id` (`mobil_id`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plat_nomor` (`plat_nomor`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indeks untuk tabel `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_promo` (`kode_promo`);

--
-- Indeks untuk tabel `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mobil_id` (`mobil_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

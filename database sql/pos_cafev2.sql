-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 07:38 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_cafev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id` int(11) NOT NULL,
  `cabang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `kode_customer` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kanal`
--

CREATE TABLE `kanal` (
  `id` int(11) NOT NULL,
  `kanal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_lainnya`
--

CREATE TABLE `keuangan_lainnya` (
  `id` int(11) NOT NULL,
  `no_ledger` varchar(255) DEFAULT NULL,
  `nama_urusan` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_ledger`
--

CREATE TABLE `keuangan_ledger` (
  `id` int(11) NOT NULL,
  `no_ledger` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `tgl_bergabung` varchar(255) NOT NULL,
  `deleted_at` varchar(255) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user`, `pass`, `nama_user`, `alamat`, `email`, `telepon`, `foto`, `level`, `tgl_bergabung`, `deleted_at`, `id_cabang`) VALUES
(5, 'adminkasir', '$2y$10$XUrgFfZ6Y1b0UeaYnYLJbu2lU51cR8r8DwWI.ISmtKYfAqntwCXT2', 'Admin Toko', 'Bekasi', 'dummy@gmail.com', '081234567890', 'user_1636966029.png', 'Admin', '2019-09-11', '2021-07-27 12:25:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga_pokok` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_minim` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `id_kanal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_stok`
--

CREATE TABLE `menu_stok` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `date` date NOT NULL,
  `periode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_toko`
--

CREATE TABLE `profil_toko` (
  `id` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `telepon_toko` varchar(25) DEFAULT NULL,
  `email_toko` varchar(255) DEFAULT NULL,
  `pemilik_toko` varchar(255) DEFAULT NULL,
  `website_toko` varchar(255) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `os` int(11) DEFAULT NULL,
  `print` int(11) DEFAULT NULL,
  `print_default` int(11) DEFAULT NULL,
  `driver` varchar(255) DEFAULT NULL,
  `footer_struk` varchar(255) DEFAULT NULL,
  `pajak` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_toko`
--

INSERT INTO `profil_toko` (`id`, `nama_toko`, `alamat_toko`, `telepon_toko`, `email_toko`, `pemilik_toko`, `website_toko`, `tgl_update`, `os`, `print`, `print_default`, `driver`, `footer_struk`, `pajak`, `voucher`, `diskon`, `user_id`) VALUES
(1, 'HONABELLE &amp; CO', 'Bekasi', '081234567890', 'halo@gmail.com', 'Anang', 'sample.com', '2021-03-07 05:25:19', 1, 1, 1, 'logo_1652604576.jpeg', 'TERIMA KASIH\r\nATAS KUNJUNGAN ANDA', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `no_bon` varchar(255) DEFAULT NULL,
  `kasir_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `atas_nama` varchar(255) DEFAULT NULL,
  `pesanan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `diskon` int(11) NOT NULL,
  `pajak` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `grandmodal` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `id_kanal` int(11) DEFAULT NULL,
  `id_pembayaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_produk`
--

CREATE TABLE `transaksi_produk` (
  `id` int(11) NOT NULL,
  `no_bon` varchar(255) DEFAULT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cabang` (`cabang`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kanal`
--
ALTER TABLE `kanal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keuangan_lainnya`
--
ALTER TABLE `keuangan_lainnya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keuangan_ledger`
--
ALTER TABLE `keuangan_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_stok`
--
ALTER TABLE `menu_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_toko`
--
ALTER TABLE `profil_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_produk`
--
ALTER TABLE `transaksi_produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kanal`
--
ALTER TABLE `kanal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=272;

--
-- AUTO_INCREMENT for table `keuangan_lainnya`
--
ALTER TABLE `keuangan_lainnya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keuangan_ledger`
--
ALTER TABLE `keuangan_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `menu_stok`
--
ALTER TABLE `menu_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `profil_toko`
--
ALTER TABLE `profil_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transaksi_produk`
--
ALTER TABLE `transaksi_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

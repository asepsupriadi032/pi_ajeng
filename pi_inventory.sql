-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2019 at 09:32 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pi_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `gambar` varchar(255) NOT NULL DEFAULT 'default.png',
  `theme` varchar(20) NOT NULL DEFAULT 'sb_admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `nama`, `status`, `gambar`, `theme`) VALUES
(2, 'admin@admin.com', 'admin', 'admin', 1, 'default.png', 'sb_admin'),
(3, 'admin@admin2.com', 'admin', 'admin kedua', 1, 'default.png', 'sb_admin');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(3) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `stok` int(4) NOT NULL,
  `harga` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`) VALUES
(1, 'sendal', 161, 15000),
(2, 'sepatu', 15, 150000),
(3, 'pensil', 966, 26000),
(4, 'pulpen', 34, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `barang_toko`
--

CREATE TABLE `barang_toko` (
  `id_barangtoko` int(11) NOT NULL,
  `id_barang` int(3) NOT NULL,
  `id_toko` int(5) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_toko`
--

INSERT INTO `barang_toko` (`id_barangtoko`, `id_barang`, `id_toko`, `stok`, `harga`) VALUES
(15, 1, 1, 10, 0),
(16, 1, 2, 26, 17500),
(17, 2, 2, 15, 80000),
(18, 3, 2, 17, 26000);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(6) NOT NULL,
  `id_toko` int(5) NOT NULL,
  `nama_customer` varchar(30) NOT NULL,
  `alamat_customer` varchar(200) NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `id_toko`, `nama_customer`, `alamat_customer`, `no_telp`) VALUES
(1, 1, 'putra', 'jalan kapuk', '089754354547'),
(3, 1, 'bagus', 'jalan margonda', '23245465767');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `nama_customer` varchar(25) NOT NULL,
  `id_toko` int(5) NOT NULL,
  `id_penerima` int(3) NOT NULL,
  `kode_penjualan` char(10) NOT NULL,
  `total_harga` int(8) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `nama_customer`, `id_toko`, `id_penerima`, `kode_penjualan`, `total_harga`, `waktu`) VALUES
(30, '', 0, 1, '1576835186', 150000, '2019-12-20 09:46:26'),
(31, '', 0, 2, '1577080370', 3852000, '2019-12-23 05:52:50'),
(32, '', 0, 2, '1577080614', 60000, '2019-12-23 05:56:54'),
(33, '', 0, 2, '1577081228', 75000, '2019-12-23 06:07:08'),
(34, '', 0, 2, '1577081271', 130000, '2019-12-23 06:07:51'),
(35, 'Bambang', 2, 0, '1577114125', 175000, '2019-12-23 15:15:25'),
(36, '', 0, 2, '1577176216', 970000, '2019-12-24 08:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id_pd` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(3) NOT NULL,
  `qty` int(4) NOT NULL,
  `harga` int(8) NOT NULL,
  `sub_total` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id_pd`, `id_penjualan`, `id_barang`, `qty`, `harga`, `sub_total`) VALUES
(35, 30, 1, 10, 15000, 150000),
(36, 31, 1, 6, 15000, 90000),
(37, 31, 2, 23, 150000, 3450000),
(38, 31, 3, 12, 26000, 312000),
(39, 32, 1, 4, 15000, 60000),
(40, 33, 1, 5, 15000, 75000),
(41, 34, 3, 5, 26000, 130000),
(42, 35, 1, 10, 17500, 175000),
(43, 36, 2, 5, 150000, 750000);

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `id_po` int(5) NOT NULL,
  `id_toko` int(5) NOT NULL,
  `kode_po` char(10) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sts` enum('sedang dipesan','sedang dikirim','diterima') NOT NULL DEFAULT 'sedang dipesan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`id_po`, `id_toko`, `kode_po`, `waktu`, `sts`) VALUES
(1, 1, '1564673278', '2019-08-01 15:28:33', 'diterima'),
(3, 1, '1565058447', '2019-12-24 06:38:12', 'sedang dipesan'),
(4, 1, '1566999431', '2019-12-24 06:38:09', 'sedang dipesan'),
(5, 1, '1576573725', '2019-12-24 06:38:03', 'sedang dipesan'),
(6, 1, '1576573848', '2019-12-17 09:10:48', 'diterima'),
(7, 1, '1576573988', '2019-12-17 09:13:08', 'diterima'),
(8, 2, '1576575005', '2019-12-24 07:11:11', 'sedang dikirim'),
(9, 2, '1577165839', '2019-12-24 05:37:19', 'diterima'),
(10, 2, '1577166435', '2019-12-24 06:37:55', 'sedang dipesan');

-- --------------------------------------------------------

--
-- Table structure for table `po_detail`
--

CREATE TABLE `po_detail` (
  `id_po_detail` int(11) NOT NULL,
  `id_po` int(5) NOT NULL,
  `id_barang` int(3) NOT NULL,
  `qty` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po_detail`
--

INSERT INTO `po_detail` (`id_po_detail`, `id_po`, `id_barang`, `qty`) VALUES
(1, 1, 1, 10),
(2, 1, 2, 10),
(3, 2, 4, 5),
(4, 2, 2, 5),
(5, 3, 2, 5),
(6, 3, 3, 5),
(7, 4, 2, 6),
(8, 5, 1, 11),
(9, 6, 1, 20),
(10, 7, 3, 5),
(11, 8, 1, 17),
(12, 9, 1, 2),
(13, 9, 2, 6),
(14, 10, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tjm_menu`
--

CREATE TABLE `tjm_menu` (
  `id` int(11) NOT NULL,
  `parent_menu` int(11) NOT NULL DEFAULT '1',
  `nama_menu` varchar(50) NOT NULL,
  `url_menu` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `urutan` tinyint(3) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` enum('Admin') NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tjm_menu`
--

INSERT INTO `tjm_menu` (`id`, `parent_menu`, `nama_menu`, `url_menu`, `icon`, `urutan`, `status`, `type`) VALUES
(1, 1, 'root', '/', '', 0, 0, 'Admin'),
(2, 1, 'dashboard', 'admin/dashboard', 'fa fa-fw fa-dashboard', 1, 1, 'Admin'),
(3, 1, 'User Admin', 'admin/useradmin', 'fa fa-users', 99, 1, 'Admin'),
(4, 1, 'Tambah Menu', 'admin/menu', 'fa fa-gear', 100, 0, 'Admin'),
(30, 1, 'Barang', 'admin/barang', 'glyphicon glyphicon-th-list', 2, 1, 'Admin'),
(31, 1, 'Toko', 'admin/toko', 'glyphicon glyphicon-home', 3, 1, 'Admin'),
(32, 1, 'Barang Toko', 'admin/barang_toko', 'glyphicon glyphicon-list-alt', 4, 0, 'Admin'),
(33, 1, 'Pre-Order', 'admin/po', 'glyphicon glyphicon-shopping-cart', 5, 1, 'Admin'),
(34, 1, 'Penjualan', 'admin/penjualan', 'glyphicon glyphicon-usd', 6, 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(5) NOT NULL,
  `nama_toko` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `alamat_toko` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `nama_toko`, `username`, `password`, `alamat_toko`) VALUES
(1, 'Toko Dadang', 'padadang', 'padadang123', 'jalan kapuk, no. 26'),
(2, 'Toko Dendi', 'denden', 'dendi123', 'jalan raya bogor nomor 15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_toko`
--
ALTER TABLE `barang_toko`
  ADD PRIMARY KEY (`id_barangtoko`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id_pd`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indexes for table `po_detail`
--
ALTER TABLE `po_detail`
  ADD PRIMARY KEY (`id_po_detail`);

--
-- Indexes for table `tjm_menu`
--
ALTER TABLE `tjm_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `barang_toko`
--
ALTER TABLE `barang_toko`
  MODIFY `id_barangtoko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id_pd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id_po` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `po_detail`
--
ALTER TABLE `po_detail`
  MODIFY `id_po_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tjm_menu`
--
ALTER TABLE `tjm_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2019 at 09:40 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
(2, 'admin@admin.com', 'admin', 'admin', 1, 'default.png', 'sb_admin');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(3) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `harga` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`) VALUES
(1, 'sendal', 15000),
(2, 'sepatu', 150000),
(3, 'pensil', 26000),
(4, 'pulpen', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `barang_toko`
--

CREATE TABLE `barang_toko` (
  `id_barangtoko` int(11) NOT NULL,
  `id_barang` int(3) NOT NULL,
  `id_toko` int(5) NOT NULL,
  `stok` int(11) NOT NULL,
  `min_stok` int(2) NOT NULL,
  `harga` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_toko`
--

INSERT INTO `barang_toko` (`id_barangtoko`, `id_barang`, `id_toko`, `stok`, `min_stok`, `harga`) VALUES
(1, 3, 1, 5, 5, 26000),
(2, 4, 1, 0, 5, 30000),
(3, 1, 1, 2, 5, 15000),
(4, 2, 1, 21, 5, 150000),
(5, 4, 2, 10, 5, 2000);

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
  `id_customer` int(6) NOT NULL,
  `id_toko` int(5) NOT NULL,
  `kode_penjualan` char(10) NOT NULL,
  `total_harga` int(8) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_customer`, `id_toko`, `kode_penjualan`, `total_harga`, `waktu`) VALUES
(1, 1, 0, '1564994912', 825000, '2019-08-05 08:48:32'),
(2, 3, 1, '1576573918', 132000, '2019-12-17 09:11:58'),
(3, 1, 2, '1576576566', 49500, '2019-12-17 09:56:06');

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
(1, 1, 2, 5, 165000, 825000),
(2, 2, 1, 8, 16500, 132000),
(3, 3, 1, 3, 16500, 49500);

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
(2, 0, '1564990343', '2019-08-05 07:32:23', 'sedang dipesan'),
(3, 1, '1565058447', '2019-08-06 02:28:06', 'diterima'),
(4, 1, '1566999431', '2019-08-28 13:37:53', 'diterima'),
(5, 1, '1576573725', '2019-12-17 09:08:45', 'diterima'),
(6, 1, '1576573848', '2019-12-17 09:10:48', 'diterima'),
(7, 1, '1576573988', '2019-12-17 09:13:08', 'diterima'),
(8, 2, '1576575005', '2019-12-17 09:30:05', 'diterima');

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
(11, 8, 1, 17);

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
(4, 1, 'Tambah Menu', 'admin/menu', 'fa fa-gear', 100, 1, 'Admin'),
(30, 1, 'Barang', 'admin/barang', 'glyphicon glyphicon-th-list', 2, 1, 'Admin'),
(31, 1, 'Toko', 'admin/toko', 'glyphicon glyphicon-home', 3, 1, 'Admin'),
(32, 1, 'Barang Toko', 'admin/barang_toko', 'glyphicon glyphicon-list-alt', 4, 1, 'Admin'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barang_toko`
--
ALTER TABLE `barang_toko`
  MODIFY `id_barangtoko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id_pd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id_po` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `po_detail`
--
ALTER TABLE `po_detail`
  MODIFY `id_po_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

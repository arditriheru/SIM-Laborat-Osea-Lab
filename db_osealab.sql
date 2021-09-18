-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 05:52 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_osealab`
--

-- --------------------------------------------------------

--
-- Table structure for table `ksr_bayar`
--

CREATE TABLE `ksr_bayar` (
  `id_ksr_bayar` int(100) NOT NULL,
  `id_lab_trn` int(100) NOT NULL,
  `bayar` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_sampel`
--

CREATE TABLE `lab_sampel` (
  `id_lab_sampel` int(3) NOT NULL,
  `nama_sampel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_sampel`
--

INSERT INTO `lab_sampel` (`id_lab_sampel`, `nama_sampel`) VALUES
(1, 'Darah'),
(2, 'Urine'),
(3, 'Tinja');

-- --------------------------------------------------------

--
-- Table structure for table `lab_tarif`
--

CREATE TABLE `lab_tarif` (
  `id_lab_tarif` int(3) NOT NULL,
  `id_lab_sampel` int(3) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nilai_normal` varchar(20) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `tarif` int(11) NOT NULL,
  `kel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_tarif`
--

INSERT INTO `lab_tarif` (`id_lab_tarif`, `id_lab_sampel`, `nama`, `nilai_normal`, `satuan`, `tarif`, `kel`) VALUES
(1, 1, 'HB (RUJUKAN)', '11-14.0', 'g/dL', 103000, 1),
(2, 1, 'AL (LEKOSIT)', '4 -11.0', '10?/?L', 64000, 1),
(3, 1, 'ASAM URAT (L)', '3.6-7.2', 'mg/dL', 54000, 2),
(4, 2, 'URIN RUTIN', '0-0.0 ', '-', 68000, 3),
(5, 1, 'HIV', 'NON REAKTIF', '-', 32000, 4),
(6, 3, 'FESES RUTIN  ', '0-0.0', 'NEGATIF', 93000, 5),
(7, 1, 'HB (HEMOGLOBIN)', '13 -18.0', 'g/dL', 64000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab_trn`
--

CREATE TABLE `lab_trn` (
  `id_lab_trn` int(100) NOT NULL,
  `id_mr_pendaftaran` int(100) NOT NULL,
  `id_petugas` int(3) NOT NULL,
  `pemeriksaan` varchar(100) NOT NULL,
  `dx` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` varchar(8) NOT NULL,
  `total_bayar` int(10) NOT NULL,
  `status_bayar` int(1) NOT NULL,
  `selesai` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_trn`
--

INSERT INTO `lab_trn` (`id_lab_trn`, `id_mr_pendaftaran`, `id_petugas`, `pemeriksaan`, `dx`, `tanggal`, `jam`, `total_bayar`, `status_bayar`, `selesai`) VALUES
(69, 30, 0, '1,7,3,4,6', 'Demam', '2021-05-24', '10:44:39', 382000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab_trn_hasil`
--

CREATE TABLE `lab_trn_hasil` (
  `id_lab_trn_hasil` int(11) NOT NULL,
  `id_lab_trn` int(100) NOT NULL,
  `id_lab_tarif` int(3) NOT NULL,
  `id_petugas` int(3) NOT NULL,
  `hasil_uji` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mr_dokter`
--

CREATE TABLE `mr_dokter` (
  `id_dokter` int(3) NOT NULL,
  `id_unit` int(2) NOT NULL,
  `nama_dokter` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mr_dokter`
--

INSERT INTO `mr_dokter` (`id_dokter`, `id_unit`, `nama_dokter`) VALUES
(1, 1, 'Soeroyo Machfudz, Sp.A (K), MPH. dr.'),
(2, 2, 'Irwan Taufiqurahman, Sp.OG (K). dr.'),
(3, 2, 'Arsi Palupi, Sp.OG. dr.'),
(4, 1, 'Restu Maharany, MSc, Sp.A. dr.'),
(5, 2, 'Marie Caesarini, Sp.OG. dr.'),
(8, 2, 'Akbar Novan Dwi, Sp.OG. dr.');

-- --------------------------------------------------------

--
-- Table structure for table `mr_pasien`
--

CREATE TABLE `mr_pasien` (
  `id_pasien` int(10) NOT NULL,
  `id_catatan_medik` int(8) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `sex` int(1) NOT NULL COMMENT '1. Laki-laki, 2. Perempuan',
  `tempat` varchar(20) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kabupaten` varchar(20) NOT NULL,
  `kecamatan` varchar(20) NOT NULL,
  `kelurahan` varchar(20) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mr_pasien`
--

INSERT INTO `mr_pasien` (`id_pasien`, `id_catatan_medik`, `nama_pasien`, `sex`, `tempat`, `tgl_lahir`, `alamat`, `kabupaten`, `kecamatan`, `kelurahan`, `telp`, `email`) VALUES
(30, 10000000, 'Umum', 1, 'Sleman', '1995-08-28', 'Sedogan 02/21', 'Sleman', 'Tempel', 'Lumbungrejo', '0896296171717', 'arditriheruh@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `mr_pendaftaran`
--

CREATE TABLE `mr_pendaftaran` (
  `id_mr_pendaftaran` int(100) NOT NULL,
  `id_catatan_medik` int(8) NOT NULL,
  `id_dokter` int(3) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` varchar(8) NOT NULL,
  `selesai` int(1) NOT NULL COMMENT '0=belum selesai, 1=selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mr_pendaftaran`
--

INSERT INTO `mr_pendaftaran` (`id_mr_pendaftaran`, `id_catatan_medik`, `id_dokter`, `tanggal`, `jam`, `selesai`) VALUES
(30, 10000000, 1, '2021-05-24', '10:44:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mr_unit`
--

CREATE TABLE `mr_unit` (
  `id_unit` int(3) NOT NULL,
  `nama_unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mr_unit`
--

INSERT INTO `mr_unit` (`id_unit`, `nama_unit`) VALUES
(1, 'POLI ANAK'),
(2, 'POLI OBSGYN');

-- --------------------------------------------------------

--
-- Table structure for table `psdi_petugas`
--

CREATE TABLE `psdi_petugas` (
  `id_petugas` int(3) NOT NULL,
  `nama_petugas` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `psdi_petugas`
--

INSERT INTO `psdi_petugas` (`id_petugas`, `nama_petugas`, `username`, `password`) VALUES
(1, 'Super Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'Ardi Tri Heru', 'arditriheru', 'cfab1ba8c67c7c838db98d666f02a132');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ksr_bayar`
--
ALTER TABLE `ksr_bayar`
  ADD PRIMARY KEY (`id_ksr_bayar`);

--
-- Indexes for table `lab_sampel`
--
ALTER TABLE `lab_sampel`
  ADD PRIMARY KEY (`id_lab_sampel`);

--
-- Indexes for table `lab_tarif`
--
ALTER TABLE `lab_tarif`
  ADD PRIMARY KEY (`id_lab_tarif`);

--
-- Indexes for table `lab_trn`
--
ALTER TABLE `lab_trn`
  ADD PRIMARY KEY (`id_lab_trn`);

--
-- Indexes for table `lab_trn_hasil`
--
ALTER TABLE `lab_trn_hasil`
  ADD PRIMARY KEY (`id_lab_trn_hasil`);

--
-- Indexes for table `mr_dokter`
--
ALTER TABLE `mr_dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `mr_pasien`
--
ALTER TABLE `mr_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `id_catatan_medik` (`id_catatan_medik`);

--
-- Indexes for table `mr_pendaftaran`
--
ALTER TABLE `mr_pendaftaran`
  ADD PRIMARY KEY (`id_mr_pendaftaran`);

--
-- Indexes for table `mr_unit`
--
ALTER TABLE `mr_unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `psdi_petugas`
--
ALTER TABLE `psdi_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ksr_bayar`
--
ALTER TABLE `ksr_bayar`
  MODIFY `id_ksr_bayar` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_sampel`
--
ALTER TABLE `lab_sampel`
  MODIFY `id_lab_sampel` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lab_tarif`
--
ALTER TABLE `lab_tarif`
  MODIFY `id_lab_tarif` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lab_trn`
--
ALTER TABLE `lab_trn`
  MODIFY `id_lab_trn` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `lab_trn_hasil`
--
ALTER TABLE `lab_trn_hasil`
  MODIFY `id_lab_trn_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mr_dokter`
--
ALTER TABLE `mr_dokter`
  MODIFY `id_dokter` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mr_pasien`
--
ALTER TABLE `mr_pasien`
  MODIFY `id_pasien` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `mr_pendaftaran`
--
ALTER TABLE `mr_pendaftaran`
  MODIFY `id_mr_pendaftaran` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `mr_unit`
--
ALTER TABLE `mr_unit`
  MODIFY `id_unit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `psdi_petugas`
--
ALTER TABLE `psdi_petugas`
  MODIFY `id_petugas` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

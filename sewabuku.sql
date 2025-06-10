-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jun 2024 pada 12.11
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewabuku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `jenis_buku` varchar(10) NOT NULL,
  `kondisi_buku` varchar(10) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `isbn`, `jenis_buku`, `kondisi_buku`, `harga_sewa`, `status`) VALUES
(1, 'The Last Secret of The Temple', 'Paul Sussman', 'PT Pustaka Alvabet', '978-979-3064-56-7', 'novel', 'baru', 5000, 'Tersedia'),
(2, 'upin ipin the explorer', 'opah', 'les copakue', '2345-3214-764-2-90', 'komik', 'lama', 1500, 'Tersedia'),
(3, 'yotsuba&! 1', 'Kiyohiko Azuma', 'Elex Media Komputindo', '978-602-02-6680-0', 'komik', 'lama', 1500, 'Tersedia'),
(4, 'yotsuba&! 2', 'Kiyohiko Azuma', 'Elex Media Komputindo', '978-602-02-6681-7', 'komik', 'lama', 1500, 'Tersedia'),
(5, 'yotsuba&! 3', 'Kiyohiko Azuma', 'Elex Media Komputindo', '978-602-02-6634-7', 'komik', 'lama', 1500, 'Tersedia'),
(7, 'yotsuba&! 4', 'Kiyohiko Azuma', 'Elex Media Komputindo', '978-602-02-6933-7', 'komik', 'lama', 1500, 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `idnya_peminjaman` int(11) NOT NULL,
  `idnya_buku` int(11) NOT NULL,
  `tenggat_pengembalian` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`idnya_peminjaman`, `idnya_buku`, `tenggat_pengembalian`, `status`) VALUES
(2, 2, '2024-06-18', 'selesai'),
(2, 3, '2024-06-18', 'selesai'),
(3, 3, '2024-06-26', 'selesai'),
(3, 4, '2024-06-26', 'selesai'),
(3, 5, '2024-06-26', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomer_hp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `nomer_hp`, `alamat`) VALUES
(1, 'Masha', '7628348823', 'Bantul'),
(7, 'kang tahu', '436463214', 'Solo'),
(8, 'amanda', '982348932', 'Jawa Barat'),
(9, 'Teteh', '083312437768', 'Babarsari');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `biaya_total` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_pelanggan`, `tgl_pinjam`, `biaya_total`, `status`) VALUES
(2, 1, '2024-06-05', 3000, 'selesai'),
(3, 1, '2024-06-19', 4500, 'selesai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`idnya_peminjaman`,`idnya_buku`),
  ADD KEY `fk_idbuku` (`idnya_buku`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `fk_idbuku` FOREIGN KEY (`idnya_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman` FOREIGN KEY (`idnya_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

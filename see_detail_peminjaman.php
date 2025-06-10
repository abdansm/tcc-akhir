<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif (isset($_GET["idpeminjaman"])) {
    $idpeminjaman = $_GET["idpeminjaman"];
    $judul = [];
    $jenis_buku = [];
    $kondisi_buku = [];
    $tenggat = [];
    $harga_sewa = [];
    $status_per_buku = [];

    include "koneksi.php";

    $query = mysqli_query($connect, "SELECT `peminjaman`.`id_peminjaman`, `pelanggan`.`nama`, `peminjaman`.`tgl_pinjam`, `peminjaman`.`biaya_total`, `peminjaman`.`status`AS 'status_pinjam', `buku`.`judul`, `buku`.`jenis_buku`, `buku`.`kondisi_buku`,detail_peminjaman.tenggat_pengembalian, buku.harga_sewa ,`detail_peminjaman`.`status`
FROM `peminjaman` 
	inner JOIN `pelanggan` ON `peminjaman`.`id_pelanggan` = `pelanggan`.`id_pelanggan`
	, `buku` 
	inner JOIN `detail_peminjaman` ON `detail_peminjaman`.`idnya_buku` = `buku`.`id_buku`
    WHERE peminjaman.id_peminjaman = '$idpeminjaman'  AND detail_peminjaman.idnya_peminjaman = '$idpeminjaman';");
    $i = 0;
    $a = 0;
    while ($data = mysqli_fetch_array($query)) {
        if ($i == 0) {
            $idpeminjaman1 = $data['id_peminjaman'];
            $namapelanggan = $data['nama'];
            $tgl_pinjam = $data['tgl_pinjam'];
            $biaya_total = $data['biaya_total'];
            $status_pinjam = $data['status_pinjam'];
        }
        $judul[$i] = $data['judul'];
        $jenis_buku[$i] = $data['jenis_buku'];
        $kondisi_buku[$i] = $data['kondisi_buku'];
        $tenggat[$i] = $data['tenggat_pengembalian'];
        $harga_sewa[$i] = $data['harga_sewa'];
        $status_per_buku[$i] = $data['status'];
        $i++;
    }
    $a = $i;
}

?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Detail Riwayat Peminjaman</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Detail Riwayat Peminjaman</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #0766ad;">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn btn-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php if ($_SESSION['username'] == 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="pemilik.php">Halaman Utama</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="insert_buku.php">Tambah Buku</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="see_peminjaman.php">Riwayat Peminjaman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="logout.php">Keluar</a>
                            </li>
                        <?php } elseif ($_SESSION['username'] == 'penjaga') { ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="penjaga.php">Halaman Utama</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="see_pelanggan.php">Data Pelanggan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="insert_peminjaman.php">Buat Peminjaman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="pengembalian.php">Pengembalian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="logout.php">Keluar</a>
                            </li>
                        <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <br><br><br>
    <button type="button" class="ms-3" onclick="window.history.back();">Kembali</button>
    <div class="container-sm">
        <div class="row">
            <div class="col-sm-4 p-3">
                <table class="table border table-borderless">
                    <thead class="table-light">
                        <tr class="fw-bold">
                            <td>Peminjaman</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tr>
                        <td>ID Peminjaman</td>
                        <td><?= $idpeminjaman1 ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td><?= $namapelanggan ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pinjam</td>
                        <td><?= $tgl_pinjam ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Status Pinjam</td>
                        <td><?= $status_pinjam ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total Biaya</td>
                        <td><?= $biaya_total ?></td>
                        <td></td>
                    </tr>
                </table>

            </div>
            <div class="col-md-7 p-3">
                <h5>Rincian Peminjaman</h5>
                <table class="table border">
                    <tr class="fw-bold">
                        <td>Judul Buku</td>
                        <td>Jenis Buku</td>
                        <td>Kondisi Buku</td>
                        <td>tenggat</td>
                        <td>harga Sewa</td>
                        <td>Status</td>
                    </tr>

                    <?php for ($i = 0; $i < $a; $i++) {
                    ?>
                        <tr>
                            <td><?php echo $judul[$i]; ?></td>
                            <td><?php echo $jenis_buku[$i]; ?></td>
                            <td><?php echo $kondisi_buku[$i]; ?></td>
                            <td><?php echo $tenggat[$i]; ?></td>
                            <td><?php echo $harga_sewa[$i]; ?></td>
                            <td><?php echo $status_per_buku[$i]; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
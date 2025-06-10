<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'admin') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
}

?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Riwayat Peminjaman</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
        <div class="container-fluid">
            <a class="navbar-brand" href="see_peminjaman.php">Riwayat Peminjaman</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #0766ad;">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn btn-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
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
                </div>
            </div>
        </div>
    </nav>
    <br><br><br>
    <button type="button" class="ms-3" onclick="window.history.back();">Kembali</button>
    <br>
    <div class="container-sm">
        <div class="row">
            <form action="" method="post">
                <label for="">Cari Berdasarkan Nama Pelanggan</label>
                <input type="text" name="cari">
                <button class="btn btn-primary p-1" type="submit"> Cari </submit>
            </form>

        </div>
    </div>
    <div class="container-sm">
        <table class="table">
            <tr class="fw-bold">
                <td>ID Peminjaman</td>
                <td>Nama Pelanggan</td>
                <td>Tanggal Pinjam</td>
                <td>Total biaya</td>
                <td>status</td>
                <td>Aksi</td>
            </tr>
            <?php
            include "koneksi.php";
            $carinama = "";
            if (isset($_POST['cari'])) {
                $carinama = $_POST['cari'];
            }

            $query = mysqli_query($connect, "SELECT `peminjaman`.`id_peminjaman`, `pelanggan`.`nama`, `peminjaman`.`tgl_pinjam`, `peminjaman`.`biaya_total`, `peminjaman`.`status`
FROM `peminjaman` 
	INNER JOIN `pelanggan` ON `peminjaman`.`id_pelanggan` = `pelanggan`.`id_pelanggan`
    WHERE pelanggan.nama LIKE '%$carinama%' ORDER BY peminjaman.status");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data['id_peminjaman']; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['tgl_pinjam']; ?></td>
                    <td><?php echo $data['biaya_total']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td><a class="btn btn-info p-1" href="see_detail_peminjaman.php?idpeminjaman=<?= $data["id_peminjaman"]; ?>">Detail</a>
                    </td>
                </tr>
            <?php }
            ?>
        </table>

    </div>


</body>

</html>
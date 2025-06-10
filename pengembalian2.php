<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
} elseif (isset($_GET["idpeminjaman"])) {
    $idpeminjaman = $_GET["idpeminjaman"];
    $judul = [];
    $idbuku = [];
    $jenis_buku = [];
    $kondisi_buku = [];
    $tenggat = [];
    $harga_sewa = [];
    $status_per_buku = [];

    include "koneksi.php";

    $query = mysqli_query($connect, "SELECT `peminjaman`.`id_peminjaman`, `pelanggan`.`nama`, `peminjaman`.`tgl_pinjam`, `peminjaman`.`biaya_total`, 
    `peminjaman`.`status`AS 'status_pinjam',buku.id_buku, `buku`.`judul`, `buku`.`jenis_buku`, `buku`.`kondisi_buku`,detail_peminjaman.tenggat_pengembalian, buku.harga_sewa ,`detail_peminjaman`.`status`
     FROM `peminjaman` 
     inner JOIN `pelanggan` ON `peminjaman`.`id_pelanggan` = `pelanggan`.`id_pelanggan` , `buku` 
     inner JOIN `detail_peminjaman` ON `detail_peminjaman`.`idnya_buku` = `buku`.`id_buku` 
     WHERE peminjaman.id_peminjaman = '$idpeminjaman' AND detail_peminjaman.idnya_peminjaman = '$idpeminjaman' AND detail_peminjaman.status = 'berlangsung'; ");
    $i = 0;
    $a = 0;
    if (mysqli_num_rows($query) > 0) {
        while ($data = mysqli_fetch_array($query)) {
            if ($i == 0) {
                $idpeminjaman1 = $data['id_peminjaman'];
                $namapelanggan = $data['nama'];
                $tgl_pinjam = $data['tgl_pinjam'];
                $biaya_total = $data['biaya_total'];
                $status_pinjam = $data['status_pinjam'];
            }
            $idbuku[$i] = $data['id_buku'];
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
}
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Pengembalian</title>
    <style>
        th {
            text-align: center;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
        <div class="container-fluid">
            <a class="navbar-brand" href="pemilik.php">Pengembalian</a>
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
            <div class="col-sm-4 p-3">
                <table class="table border table-borderless">
                    <thead class="table-light">
                        <tr class="fw-bold">
                            <td>Peminjaman</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <?php if ($a > 0) { ?>
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
                    <?php } ?>
                </table>

            </div>
            <div class="col-md-7 p-3">
                <h5>Pilih Buku yang akan dikembalikan</h5>
                <table class="table border">
                    <tr class="fw-bold">
                        <td>Judul</td>
                        <td>Jenis Buku</td>
                        <td>Kondisi</td>
                        <td>tenggat</td>
                        <td>harga</td>
                        <td>Status</td>
                        <td>Checklist</td>
                    </tr>
                    <form action="" method="post">
                        <?php if ($a > 0) {
                            for ($i = 0; $i < $a; $i++) {
                        ?>
                                <tr>
                                    <td><?php echo $judul[$i]; ?></td>
                                    <td><?php echo $jenis_buku[$i]; ?></td>
                                    <td><?php echo $kondisi_buku[$i]; ?></td>
                                    <td><?php echo $tenggat[$i]; ?></td>
                                    <td><?php echo $harga_sewa[$i]; ?></td>
                                    <td><?php echo $status_per_buku[$i]; ?></td>
                                    <th><input class="form-check-input" type="checkbox" name="check[]" value="<?= $idbuku[$i] ?>"></th>
                                </tr>
                        <?php }
                        } ?>
                </table>
                <button class="btn btn-Primary p-1" type="submit" name="submit" onclick="if(!confirm('Simpan perubahan?')){ event.preventDefault() }">Simpan Perubahan</button>
                </form>
                <?php
                if (isset($_POST["submit"])) {
                    if (!empty($_POST["check"])) {
                        $stringidbuku = implode(",", $_POST["check"]);

                        $query = mysqli_query($connect, "UPDATE `buku` SET `status`='Tersedia' WHERE id_buku IN ($stringidbuku); ")
                            or die(mysqli_error($connect));

                        $query = mysqli_query($connect, "UPDATE detail_peminjaman SET `status`='selesai' WHERE idnya_buku IN ($stringidbuku); ")
                            or die(mysqli_error($connect));
                        $jumlahbuku = count($idbuku);
                        $jumlahkembali = count($_POST["check"]);
                        if ($jumlahkembali == $jumlahbuku) {
                            $query = mysqli_query($connect, "UPDATE peminjaman SET `status`='selesai' WHERE id_peminjaman = $idpeminjaman; ")
                                or die(mysqli_error($connect));
                        }

                        echo '<script> window.location.href = "pengembalian.php";</script>';
                    } else {
                        echo "<br> Belum Dilakukan Perubahan";
                    }
                }




                ?>

            </div>
        </div>
    </div>
</body>

</html>
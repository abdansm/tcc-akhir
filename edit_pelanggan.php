<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
} elseif (isset($_GET["idpelanggan"])) {

    include "koneksi.php";

    $idpelanggan = $_GET["idpelanggan"];
    $query = mysqli_query($connect, "SELECT * from pelanggan where id_pelanggan = '$idpelanggan'; ");
    while ($data = mysqli_fetch_array($query)) {
        $nama = $data['nama'];
        $noHP = $data['nomer_hp'];
        $alamat = $data['alamat'];
    }

?>

    <html>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Edit Pelanggan</title>
    </head>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
            <div class="container-fluid">
                <a class="navbar-brand" href="">Edit Pelanggan</a>
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
                    </div>
                </div>
            </div>
        </nav>
        <br><br><br>
        <button type="button" class="ms-3" onclick="window.history.back();">Kembali</button>
        <br>
        <div class="container-sm">

            <form action="" method="post">
                <table class="table">
                    <tr>
                        <td><label>Nama</label></td>
                        <td><input type="text" name="nama" placeholder="nama" value="<?= $nama ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Nomor HP</label></td>
                        <td><input type="text" name="nohp" placeholder="nomor HP" value="<?= $noHP ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td><input type="text" name="alamat" placeholder="Alamat" value="<?= $alamat ?>" required></td>
                    </tr>

                </table>
                <button class="btn btn-primary mb-10" type="submit" onclick="if(!confirm('Simpan Perubahan pada data pelanggan ini?')){ event.preventDefault() }">Submit</submit>
            </form>
        </div>
        <?php

        if (isset($_POST['nama']) && isset($_POST['nohp']) && isset($_POST['alamat'])) {
            $nama = $_POST['nama'];
            $noHP = $_POST['nohp'];
            $alamat = $_POST['alamat'];


            $query = mysqli_query($connect, "update pelanggan set nama = '$nama',
        nomer_hp = '$noHP',alamat = '$alamat' where id_pelanggan = $idpelanggan")
                or die(mysqli_error($connect));
            mysqli_close($connect);

            echo '<script> window.location.href = "see_pelanggan.php";</script>';
        }
        ?>

    </body>


    </html>

<?php } ?>
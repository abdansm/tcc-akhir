<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'admin') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
} elseif (isset($_GET["idbuku"])) {
    $idbuku = $_GET["idbuku"];

    include "koneksi.php";
    $query = mysqli_query($connect, "Select * from buku where id_buku = $idbuku");
    while ($data = mysqli_fetch_array($query)) {
        $judul = $data['judul'];
        $pengarang = $data['pengarang'];
        $penerbit = $data['penerbit'];
        $isbn = $data['isbn'];
        $jenis_buku = $data['jenis_buku'];
        $kondisi = $data['kondisi_buku'];
        $harga = $data['harga_sewa'];
        $status = $data['status'];
    }

?>

    <html>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Edit Buku</title>
    </head>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
            <div class="container-fluid">
                <a class="navbar-brand" href="">Edit Buku</a>
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

            <form action="" method="post">
                <table class="table">
                    <tr>
                        <td><label>Judul</label></td>
                        <td><input type="text" name="judul" placeholder="Judul" value="<?= $judul ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Pengarang</label></td>
                        <td><input type="text" name="pengarang" placeholder="Pengarang" value="<?= $pengarang ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Penerbit</label></td>
                        <td><input type="text" name="penerbit" placeholder="Penerbit" value="<?= $penerbit ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>ISBN</label></td>
                        <td><input type="text" name="isbn" placeholder="ISBN" value="<?= $isbn ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Harga Sewa</label></td>
                        <td><input type="number" name="harga" placeholder="Hargasewa" value="<?= $harga ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Buku</label></td>
                        <td><select name="jenis_buku" required>
                                <option value="komik" <?php if ($jenis_buku == "komik") {
                                                            echo "selected";
                                                        } ?>>Komik</option>
                                <option value="novel" <?php if ($jenis_buku == "novel") {
                                                            echo "selected";
                                                        } ?>>Novel</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td><label>Kondisi</label></td>
                        <td><select name="kondisi" required>
                                <option value="baru" <?php if ($kondisi == "baru") {
                                                            echo "selected";
                                                        } ?>>Baru</option>
                                <option value="lama" <?php if ($kondisi == "lama") {
                                                            echo "selected";
                                                        } ?>>Lama</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td><label>Status</label></td>
                        <td><select name="status" required>
                                <option value="Tersedia" <?php if ($status == "Tersedia") {
                                                                echo "selected";
                                                            } ?>>Tersedia</option>
                                <option value="Kosong" <?php if ($status == "Kosong") {
                                                            echo "selected";
                                                        } ?>>Kosong</option>
                            </select></td>
                    </tr>
                </table>
                <button class="btn btn-primary mb-10" type="submit" onclick="if(!confirm('Simpan Perubahan pada data buku ini?')){ event.preventDefault() }">Submit</submit>
            </form>
        </div>
        <?php

        if (isset($_POST['judul']) && isset($_POST['pengarang']) && isset($_POST['penerbit']) && isset($_POST['pengarang']) && isset($_POST['harga'])) {
            $judul = $_POST['judul'];
            $pengarang = $_POST['pengarang'];
            $penerbit = $_POST['penerbit'];
            $isbn = $_POST['isbn'];
            $jenis_buku = $_POST['jenis_buku'];
            $kondisi = $_POST['kondisi'];
            $harga = $_POST['harga'];
            $status = $_POST['status'];

            $query = mysqli_query($connect, "update buku set judul = '$judul',
            pengarang = '$pengarang',penerbit = '$penerbit',isbn = '$isbn', 
            jenis_buku = '$jenis_buku',kondisi_buku = '$kondisi', harga_sewa ='$harga' , status = '$status' where id_buku = $idbuku")
                or die(mysqli_error($connect));
            mysqli_close($connect);

            echo '<script> window.location.href = "pemilik.php";</script>';
        }
        ?>

    </body>


    </html>

<?php } ?>
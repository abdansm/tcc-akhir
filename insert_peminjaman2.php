<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
} elseif (isset($_GET["idpelanggan"])) {
    $idpelanggan = $_GET["idpelanggan"];
    $_SESSION["idpelanggan"] = $idpelanggan;
}
include "koneksi.php";
$_SESSION["listDate"] = [];
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Peminjaman</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Peminjaman</a>
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

    <form action="" method="post">
        <label for="">Cari Berdasarkan Judul</label>
        <input type="text" name="cari">
        <button class="btn btn-primary p-1" type="submit"> Cari </button>
    </form>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 p-3">
                <table class="table border">
                    <tr class="fw-bold">
                        <td>ID</td>
                        <td>Judul</td>
                        <td>Pengarang</td>
                        <td>Penerbit</td>
                        <td>Jenis Buku</td>
                        <td>kondisi</td>
                        <td>Harga</td>
                        <td>Aksi</td>
                    </tr>

                    <?php
                    $carijudul = "";
                    if (isset($_POST['cari'])) {
                        $carijudul = $_POST['cari'];
                    }
                    $query = mysqli_query($connect, "SELECT * from buku where judul LIKE '%$carijudul%' AND buku.status = 'Tersedia'");

                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $data['id_buku']; ?></td>
                            <td><?php echo $data['judul']; ?></td>
                            <td><?php echo $data['pengarang']; ?></td>
                            <td><?php echo $data['penerbit']; ?></td>
                            <td><?php echo $data['jenis_buku']; ?></td>
                            <td><?php echo $data['kondisi_buku']; ?></td>
                            <td><?php echo $data['harga_sewa']; ?></td>
                            <td>
                                <a class="btn btn-primary p-1" href="insert_peminjaman3.php?idbuku=<?= $data['id_buku'] ?>"> Pilih</a>
                            </td>

                        </tr>

                    <?php } ?>

                </table>
            </div>

            <div class="col-sm-6 p-3">
                <h5>List Buku yang akan Dipinjam</h5>
                <table class="table border">
                    <tr class="fw-bold">
                        <td>Judul Buku</td>
                        <td>Jenis Buku</td>
                        <td>Kondisi Buku</td>
                        <td>tenggat</td>
                        <td>harga Sewa</td>
                        <td>Aksi</td>
                    </tr>

                    <?php
                    if (!empty($_SESSION["idbuku2"])) {
                        $Listidbuku = implode(",", $_SESSION["idbuku2"]);
                        $i = 0;
                        $totalharga = 0;
                        $lamawaktu;
                        $date = date_create(date("Y-m-d"));
                        $query = mysqli_query($connect, "SELECT * from buku where id_buku IN ($Listidbuku)");
                        while ($data = mysqli_fetch_array($query)) {
                            if ($data['jenis_buku'] == "komik" && $data['kondisi_buku'] == "lama") {
                                $lamawaktu = "7 days";
                            } else if ($data['jenis_buku'] == "komik" && $data['kondisi_buku'] == "baru") {
                                $lamawaktu = "1 days";
                            } else if ($data['jenis_buku'] == "novel" && $data['kondisi_buku'] == "lama") {
                                $lamawaktu = "14 days";
                            } else if ($data['jenis_buku'] == "novel" && $data['kondisi_buku'] == "baru") {
                                $lamawaktu = "4 days";
                            }
                            date_add($date, date_interval_create_from_date_string($lamawaktu));
                            $_SESSION["listDate"][$i] = date_format($date, "Y-m-d");
                            $date = date_create(date("Y-m-d"));
                            $totalharga = $totalharga + $data['harga_sewa'];

                    ?>
                            <tr>
                                <td><?php echo $data['judul']; ?></td>
                                <td><?php echo $data['jenis_buku']; ?></td>
                                <td><?php echo $data['kondisi_buku']; ?></td>
                                <td><?php echo $_SESSION["listDate"][$i]; ?></td>
                                <td><?php echo $data['harga_sewa']; ?></td>
                                <td><a class="btn btn-danger p-1" href="remove_listbuku.php?idbuku=<?= $data['id_buku'] ?>">Remove</a></td>
                            </tr>

                    <?php $i++;
                        }
                    } ?>
                </table>
                <h5>Total Harga = <?php if (!empty($_SESSION["idbuku2"])) {
                                        echo $totalharga;
                                    } ?></h5>
                <a class="btn btn-Primary p-1" href="insert_peminjaman4.php?totalbiaya=<?= $totalharga ?>" onclick="if(!confirm('Simpan data peminjaman ini?')){ event.preventDefault() }">Simpan Peminjaman</a>
                <a class="btn btn-danger p-1" href="remove_listbuku.php?idbuku=0" onclick="if(!confirm('Reset List buku ini?')){ event.preventDefault() }">Reset List</a>
            </div>
        </div>
    </div>

</body>


</html>
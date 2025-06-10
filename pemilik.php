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
    <title>Pemilik</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
        <div class="container-fluid">
            <a class="navbar-brand" href="pemilik.php">Halaman Utama | <?php echo $_SESSION['username']; ?></a>
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
                <label for="">Cari Berdasarkan Judul</label>
                <input type="text" name="cari">
                <button class="btn btn-primary p-1" type="submit"> Cari </submit>
            </form>

        </div>
    </div>
    <div class="container-sm">
        <table class="table">
            <tr class="fw-bold">
                <td>ID</td>
                <td>Judul</td>
                <td>Pengarang</td>
                <td>Penerbit</td>
                <td>ISBN</td>
                <td>Jenis Buku</td>
                <td>kondisi</td>
                <td>Harga</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
            <?php
            include "koneksi.php";
            $carinama = "";
            if (isset($_POST['cari'])) {
                $carinama = $_POST['cari'];
            }
            $query = mysqli_query($connect, "Select * from buku where judul LIKE '%$carinama%'");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data['id_buku']; ?></td>
                    <td><?php echo $data['judul']; ?></td>
                    <td><?php echo $data['pengarang']; ?></td>
                    <td><?php echo $data['penerbit']; ?></td>
                    <td><?php echo $data['isbn']; ?></td>
                    <td><?php echo $data['jenis_buku']; ?></td>
                    <td><?php echo $data['kondisi_buku']; ?></td>
                    <td><?php echo $data['harga_sewa']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td><a class="btn btn-primary p-1 mb-1" href="edit_buku.php?idbuku=<?= $data["id_buku"]; ?>">Edit</a>
                        <a class="btn btn-danger p-1" href="delete_buku.php?idbuku=<?= $data["id_buku"]; ?>" onclick="if(!confirm('Hapus data buku ini?')){ event.preventDefault() }">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </div>


</body>

</html>
<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'admin') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
} elseif (isset($_GET["idbuku"])) {

    include "koneksi.php";

    $idbuku = $_GET["idbuku"];
    $query = mysqli_query($connect, "delete from buku where id_buku = '$idbuku'; ");

    header("location:pemilik.php");
}

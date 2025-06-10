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
    $query = mysqli_query($connect, "delete from pelanggan where id_pelanggan = '$idpelanggan'; ");

    header("location:see_pelanggan.php");
}

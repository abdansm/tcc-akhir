<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
}
include "koneksi.php";
$idpelanggan = $_SESSION["idpelanggan"];
$tgl_pinjam = date("Y-m-d");
$biayatotal = $_GET["totalbiaya"];
$status = "berlangsung";
$id_peminjaman;

$string_query1 = [];



$query = mysqli_query($connect, "INSERT INTO `peminjaman`(`id_pelanggan`, `tgl_pinjam`, `biaya_total`, `status`) VALUES ('$idpelanggan','$tgl_pinjam','$biayatotal','$status')")
    or die(mysqli_error($connect));

$query = mysqli_query($connect, "SELECT MAX(id_peminjaman) AS 'id_peminjaman' FROM `peminjaman`; ")
    or die(mysqli_error($connect));

if (mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $id_peminjaman = $data['id_peminjaman'];
    }
}
$i = 0;
$string_query2 = "INSERT INTO `detail_peminjaman`(`idnya_peminjaman`, `idnya_buku`, `tenggat_pengembalian`, `status`) 
VALUES";
foreach ($_SESSION["idbuku2"] as $idbuku) {
    $tgl = $_SESSION['listDate'][$i];
    $string_query1[$i] = "('$id_peminjaman','$idbuku','$tgl','berlangsung')";
    $i++;
}
$string_query2 .= implode(",", $string_query1);

$query = mysqli_query($connect, $string_query2)
    or die(mysqli_error($connect));

$listbuku = implode(",", $_SESSION["idbuku2"]);
$query = mysqli_query($connect, "UPDATE `buku` SET `status`='Kosong' WHERE id_buku IN ($listbuku); ")
    or die(mysqli_error($connect));

$_SESSION["idbuku2"] = [];

mysqli_close($connect);

header("location:penjaga.php");

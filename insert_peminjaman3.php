<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:index.php?msg=unauthorized_access");
}
include "koneksi.php";

$idbuku = $_GET["idbuku"];
if (empty($_SESSION["idbuku2"])) {
    $_SESSION["idbuku2"] = array();
}
if (empty($_SESSION["counter"])) {
    $_SESSION["counter"] = 0;
}

array_push($_SESSION["idbuku2"], $idbuku);
$_SESSION["idbuku2"] = array_unique($_SESSION["idbuku2"]);
$_SESSION["counter"]++;
header("location:insert_peminjaman2.php");

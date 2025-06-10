<?php
session_start();
$username = $_GET["username"];
if(empty($_SESSION["username"])){
    header("location:index.php?msg=need_login");
}
else 
if($username == 'penjaga'){
    header("location:penjaga.php"); 
}else if ($username == 'admin') {
    header("location:pemilik.php"); 
}

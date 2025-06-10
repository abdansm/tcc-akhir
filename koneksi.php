<?php
$hostname="34.29.233.49";
$username="abdansm";
$password   = "Kalkun157@";          
 $database   = "sewabuku";   
$connect=new mysqli($hostname,$username,$password, $database);
if ($connect->connect_error) {
    die('Maaf koneksi gagal: '. $connect->connect_error);
}

<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];





if($username == 'penjaga' && $password == 'penjaga_123'){
    $_SESSION["username"] = "penjaga";
    
    
    header("location:session.php?username=$username");
}
elseif($username == 'admin' && $password == 'pemilik'){
    $_SESSION["username"] = $username;
    header("location:session.php?username=$username");
}
else{
    header("location:index.php?msg=failed");
}

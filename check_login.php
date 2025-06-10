<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];


function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


if($username == 'penjaga' && $password == 'penjaga_123'){
    $_SESSION["username"] = "penjaga";
    debug_to_console("sesuatu terjadi");
    debug_to_console($_SESSION["username"]);
    
    header("location:session.php?username=$username");
}
elseif($username == 'admin' && $password == 'pemilik'){
    $_SESSION["username"] = $username;
    header("location:session.php?username=$username");
}
else{
    header("location:index.php?msg=failed");
}

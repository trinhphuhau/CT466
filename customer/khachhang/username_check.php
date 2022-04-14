<?php
    require ("../connect.php");
    $username = $_GET["username"];
    $check = $conn->query("SELECT * FROM khachhang WHERE username = '$username'");
    if ($check->num_rows == 1) {
        echo "0";
    }
    $conn->close();
?>
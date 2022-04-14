<?php
    $conn = new mysqli("localhost", "root", "", "qlshop");
    $conn->set_charset("utf8");
    $url = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
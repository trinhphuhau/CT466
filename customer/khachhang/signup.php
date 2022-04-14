<?php
    require ("../connect.php");
    session_start();
    if ($_POST["username"]) {
        $fullname = $_POST["fullname"];
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        $redirect = $_POST["redirect"];
        $sdt = $_POST["sdt"];
        $sql = $conn->query('INSERT INTO khachhang (hoten, username, password, sdt) VALUES ("'.$fullname.'", "'.$username.'", "'.$password.'", "'.$sdt.'")');
        if ($sql) {
            $_SESSION["idkh"] = $conn->insert_id;
            header("location: $redirect");
        }
    } else
        header("location: ../index.php");
    $conn->close();
?>
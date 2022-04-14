<?php
    require ("../connect.php");
    session_start();
    $old_pw = md5($_POST["old_pw"]);
    $new_pw = md5($_POST["new_pw"]);
    $idkh = $_SESSION["idkh"];

    $check = $conn->query("SELECT * FROM khachhang WHERE idkh = '$idkh'");
    $row_check = $check->fetch_assoc();
    // echo $row_check["password"];
    if ($old_pw == $row_check["password"]) {
        $sql = "UPDATE khachhang SET password = '$new_pw' WHERE idkh = '$idkh'";
        $change = $conn->query($sql);
        if ($change) {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "-1";
    }

    $conn->close();
?>
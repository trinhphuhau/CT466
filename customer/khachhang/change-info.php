<?php
    require ("../connect.php");
    session_start();

    $idkh = $_SESSION["idkh"];
    $hoten = $_GET["hoten"];
    $sdt = $_GET["sdt"];
    $diachi = $_GET["diachi"];
    $matp = $_GET["tinhtp"];
    $maqh = $_GET["quanhuyen"];
    $xaid = $_GET["xaphuongtt"];

    $sql = "UPDATE khachhang SET hoten = '$hoten', sdt = '$sdt', diachi = '$diachi', matp = '$matp', maqh = '$maqh', xaid = '$xaid' WHERE idkh = '$idkh'";

    $change = $conn->query($sql);

    if ($change) {
        echo "1";
    } else {
        echo "0";
    }

    $conn->close();
?>
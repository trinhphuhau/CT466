<?php
    require ("../connect.php");
    $mathongbao = $_GET['mathongbao'];
    $xoathongbao = $conn->query("DELETE FROM thongbaoadmin WHERE mathongbao = '$mathongbao'");
    echo "DELETE FROM thongbaoadmin WHERE mathongbao = '$mathongbao'";
    header("location: thongbao.php");
    $conn->close();
?>
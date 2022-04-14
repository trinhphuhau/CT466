<?php
    require ("connect.php");
    // if ($_POST['macv'] == "ad") {
    //     $thongbao = $_POST['thongbao'];
    //     $thoigian = $_POST['thoigian'];
    //     $idnv = $_POST['idnv'];
    //     $conn->query("INSERT INTO thongbaoadmin (thongbao, date, idnv) VALUES ('$thongbao', '$thoigian', '$idnv')");
    //     header("location: thongbao.php");
    // } else {
    //     header("location: ../index.php");
    // }
    $thongbao = $_POST['description'];
    $thoigian = $_POST['thoigian'];
    $idnv = $_POST['idnv'];
    $conn->query("INSERT INTO thongbaoadmin (thongbao, date, idnv) VALUES ('$thongbao', '$thoigian', '$idnv')");
    echo 'success';
    $conn->close();
?>
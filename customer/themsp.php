<?php
    require ("connect.php");
    $ten = $_POST["ten"];
    $giaban = $_POST["giaban"];
    $maloai = $_POST["maloai"];
    $gioitinh = $_POST["gioitinh"];
    $mota = $_POST["mota"];
    $chatlieu = $_POST["chatlieu"];
    $duongdan = "product/img/". $_FILES["hinhanh"]["name"];
    $themsp = 'INSERT INTO sanpham (ten, chatlieu, giaban, maloai, gioitinh, mota, hinhanh)
               VALUES ("'.$ten.'", "'.$chatlieu.'", "'.$giaban.'", "'.$maloai.'", "'.$gioitinh.'", "'.$mota.'", "'.$duongdan.'")';
    echo $themsp;
    $conn->query($themsp);
    // $idsp = $conn->insert_id;
    move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $duongdan);
    // $themkhohang = "INSERT INTO khohang VALUES ("$idsp", 0, 0)";
    // $conn->query($themkhohang);
    // header("location: sanpham.php?s=$tensp");
    header("location: upload.php");
    $conn->close();
?>
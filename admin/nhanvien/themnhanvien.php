<?php
    require ("../connect.php");
    session_start();
    $hoten      = $_POST['name'];
    $sdt        = $_POST['phone'];
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $diachi     = $_POST['address'];
    $matp       = $_POST['tinhtp'];
    $maqh       = $_POST['quanhuyen'];
    $xaid       = $_POST['xaphuongtt'];
    $macv       = $_POST['macv'];
    $conn->autocommit(FALSE);
    $nhanvien  = "INSERT INTO nhanvien (hoten, sdt, macv, diachi, matp, maqh, xaid, username, password)
                  VALUES ('$hoten', '$sdt', '$macv', '$diachi', '$matp', '$maqh', '$xaid', '$username', '$password')";
    $nhanvien_add = $conn->query($nhanvien);
    if (!$nhanvien_add) {
        $conn->rollback();
    } else {
        $conn->commit();
        echo 'success';
    }
    $conn->close();
?>
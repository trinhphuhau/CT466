<?php
    require ("../connect.php");
    session_start();
    $idnv = $_GET['idnv'];
    $macv = $_GET['macv'];
    
    $conn->autocommit(FALSE);
    $sql = "UPDATE nhanvien
            SET macv = '$macv'
            WHERE idnv = '$idnv'";
    $update = $conn->query($sql);
    
    if (!$update) {
        $conn->rollback();
    } else {
        echo 'success';
        $conn->commit();
    }
?>
<?php
    require ("../connect.php");
    $idkh = $_POST['idkh'];
    $password = md5($_POST['pw']);
    
    $conn->autocommit(FALSE);

    $sql = "UPDATE khachhang
            SET password = '$password'
            WHERE idkh = '$idkh'";

    $update = $conn->query($sql);
    
    if (!$update) {
        echo $sql;
        $conn->rollback();
    } else {
        echo 'success';
        $conn->commit();
    }
?>
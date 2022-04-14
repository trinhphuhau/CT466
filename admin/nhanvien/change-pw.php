<?php
    require ("../connect.php");
    $idnv = $_POST['idnv'];
    $password = $_POST['pw'];
    
    $conn->autocommit(FALSE);

    $sql = "UPDATE nhanvien
            SET password = '$password'
            WHERE idnv = '$idnv'";
    $update = $conn->query($sql);
    
    if (!$update) {
        echo $sql;
        $conn->rollback();
    } else {
        echo 'success';
        $conn->commit();
    }
?>
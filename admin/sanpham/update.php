<?php
    require ("../connect.php");
    $idsp     = $_POST['idsp'];
    $ten      = $_POST['name'];
    $giaban   = $_POST['price'];
    $maloai   = $_POST['type'];
    $gioitinh = $_POST['gender'.$idsp.''];
    $mota     = $_POST['description'];
    $chatlieu = $_POST['chatlieu'];
    $hinhanh  = $_FILES['hinhanh'];
    $conn->autocommit(FALSE);
    if(isset($_POST['confirm'])) {
        $tinhtrang = 1;
    } else {
        $tinhtrang = 0;
    }
    if ($hinhanh['error'] == 4) {
        $sql = "UPDATE sanpham
                SET ten       = '$ten',
                    giaban    = '$giaban',
                    maloai    = '$maloai',
                    gioitinh  = '$gioitinh',
                    mota      = '$mota',
                    tinhtrang = '$tinhtrang',
                    chatlieu  = '$chatlieu'
                WHERE idsp = '$idsp'";
        $update = $conn->query($sql);
    } else {
        $ext = pathinfo($hinhanh['name'], PATHINFO_EXTENSION);
        $img_name = $idsp . "_" . time() . "." . $ext;
        $duongdan = "../../product/img/". $img_name;
        $sql = "UPDATE sanpham
                SET ten       = '$ten',
                    giaban    = '$giaban',
                    maloai    = '$maloai',
                    gioitinh  = '$gioitinh',
                    mota      = '$mota',
                    tinhtrang = '$tinhtrang',
                    chatlieu  = '$chatlieu',
                    hinhanh   = '$duongdan'
                WHERE idsp = '$idsp'";
        $update = $conn->query($sql);
        move_uploaded_file($_FILES['hinhanh']['tmp_name'], $duongdan);
    }
    
    if (!$update) {
        $conn->rollback();
    } else {
        echo 'success';
        $conn->commit();
    }
    
    $conn->close();
?>
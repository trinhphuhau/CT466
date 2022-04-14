<?php
    require ("../connect.php");
    $ten      = $_POST['name'];
    $chatlieu = $_POST['chatlieu'];
    $giaban   = $_POST['price'];
    $maloai   = $_POST['type'];
    $gioitinh = $_POST['gender'];
    $mota     = $_POST['description'];
    $date     = $_POST['dateadded'];
    $hinhanh  = $_FILES['hinhanh'];
    if (isset($_POST['confirm'])) {
        $tinhtrang = 1;
    } else {
        $tinhtrang = 0;
    }

    if ($hinhanh['error'] == 4) {
        $duongdan = "img/cloth.png";
        $sql = "INSERT INTO sanpham (ten, giaban, maloai, gioitinh, mota, tinhtrang, chatlieu, hinhanh, dateadded)
                VALUES ('$ten', '$giaban', '$maloai', '$gioitinh', '$mota', '$tinhtrang', '$chatlieu', '$duongdan', '$date')";
        $conn->query($sql);
    } else {
        $ext = pathinfo($hinhanh['name'], PATHINFO_EXTENSION);
        $img_name = time() . "." . $ext;
        $duongdan = "../../product/img/". $img_name;
        $sql = "INSERT INTO sanpham (ten, giaban, maloai, gioitinh, mota, tinhtrang, chatlieu, hinhanh, dateadded)
                VALUES ('$ten', '$giaban', '$maloai', '$gioitinh', '$mota', '$tinhtrang', '$chatlieu', '$duongdan', '$date')";
        $conn->query($sql);
        move_uploaded_file($_FILES['hinhanh']['tmp_name'], $duongdan);
    }
    
    echo 'success';
    
    $conn->close();
?>
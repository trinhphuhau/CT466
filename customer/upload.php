<?php require ("connect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="themsp.php" method="post" enctype="multipart/form-data">
        Tên
        <input type="text" name="ten"><br>
        Chất liệu
        <input type="text" name="chatlieu"><br>
        Giá bán
        <input type="text" name="giaban"><br>
        Giới tính
        <select name="gioitinh">
            <option value="0">Unisex</option>
            <option value="1">Nữ</option>
            <option value="2">Nam</option>
        </select><br>
        Mô tả
        <input type="text" name="mota"><br>
        Thể loại
        <select name="maloai">
        <?php
            $count = $conn->query("SELECT COUNT(maloai) AS total FROM loai");
            $cnt = $count->fetch_assoc();
            $total_tl = $cnt['total'];
            $result = $conn->query("SELECT maloai, tenloai FROM loai");
            while($row = $result->fetch_assoc()){
                echo "<option value='".$row['maloai']."'>".$row['tenloai']."</option>";
            }
        ?>
        </select><br>
        Hình ảnh
        <input type="file" name="hinhanh" id="hinhanh"><br>
        Bottom Top
        <select name="quan_ao">
            <option value="0">Bottom</option>
            <option value="1">Top</option>
        </select><br>
        <input type="submit" value="OK">
    </form>
</body>
</html>
<?php
    require ("../connect.php");
    $madh = $_POST['madh'];
    $matt = $_POST['matt'];
    $thoigian = $_POST['thoigian'];
    $dh_idsp = array();
    $dh_solg = array();
    $i = 0;
    
    // $conn->autocommit(FALSE);

    $result = $conn->query("UPDATE donhang
                            SET matt = '$matt'
                            WHERE madh = '$madh'");

    // Trừ số lượng trong kho hàng nếu đơn hàng đang vận chuyển
    $chitietdh = $conn->query("SELECT * FROM donhangchitiet
                               WHERE madh = '$madh'");

    if ($matt == "dvc") {
        while($row_dh = $chitietdh->fetch_assoc()) {
            $dh_idsp[$i] = $row_dh["idsp"];
            $dh_solg[$i] = $row_dh["solg"];
            $i++;
        }

        for($j = 0; $j < count($dh_idsp); $j++) {
            $trusolg = $conn->query("UPDATE khohang
                                    SET solgton = khohang.solgton-$dh_solg[$j]
                                    WHERE idsp = '$dh_idsp[$j]'");
        }
    }

    $check = $conn->query("SELECT * FROM donhangthoigian
                           WHERE madh = '$madh'
                           AND matt = '$matt'");

    if ($check->num_rows > 0) {
        $themthoigian = $conn->query("UPDATE donhangthoigian
                                      SET thoigian = '$thoigian'
                                      WHERE madh = '$madh'
                                      AND matt = '$matt'");
    } else {
        $themthoigian = $conn->query("INSERT INTO donhangthoigian
                                      VALUES ('$madh', '$matt', '$thoigian')");
    }

    echo 'success';
    
    // if (!$result || !$themthoigian) {
    //     $_SESSION['message--tt'] = "Thất bại, đã có lỗi xảy ra!";
    //     $conn->rollback();
    //     $_SESSION['load'] = "window.onload = suaTinhTrang($madh);";
    //     header("location: $url");
    // } else {
    //     $_SESSION['message--tt'] = "Đã cập nhật thành công.";
    //     $conn->commit();
    //     $_SESSION['load'] = "window.onload = suaTinhTrang($madh);";
    //     header("location: donhang.php?tt=$matt&s=$madh");
    // }
?>
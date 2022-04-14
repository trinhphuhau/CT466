<?php
    require ("../connect.php");
    session_start();
    if(isset($_SESSION['idkh']) && isset($_POST['madh'])){
        $matt = "dh";
        $madh = $_POST['madh'];
        // $lydo = $_POST['lydo'];
        $redirect = $_POST['redirect'];
        $lydo = "";
        $thoigian = $_POST['thoigian'];
        
        $conn->autocommit(FALSE);
    
        $result = $conn->query("UPDATE donhang
                                SET matt = '$matt'
                                WHERE madh = '$madh'");

        $donhanghuy = $conn->query("INSERT INTO donhanghuy
                                    VALUES ('$madh', '$lydo')");

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

        if (!$result || !$themthoigian || !$donhanghuy) {
            $conn->rollback();
            header("location: ordered-history.php");
        } else {
            $conn->commit();
            header("location: $redirect");
        }
    }
?>
<?php
    require ("../connect.php");
    session_start();
    if(isset($_SESSION['idkh']) && isset($_SESSION['cart']) && $_POST['sanpham']) {
        $sanpham        = array();
        $giaban         = array();
        $solg           = array();
        $idkh           = $_SESSION['idkh'];
        $hoten          = $_POST['hoten'];
        $sdt            = $_POST['sdt'];
        $diachi         = $_POST['diachi'];
        $matp           = $_POST['matp'];
        $maqh           = $_POST['maqh'];
        $xaid           = $_POST['xaid'];
        $note           = $_POST['note'];
        $tongtienhang   = $_POST['tongtienhang'];
        $phivanchuyen   = $_POST['phivanchuyen'];
        $sanpham        = explode(', ', $_POST['sanpham']);
        $giaban         = explode(', ', $_POST['giaban']);
        $solg           = explode(', ', $_POST['solg']);
        $kichthuoc      = explode(', ', $_POST['kichthuoc']);
        $thoigian       = $_POST['thoigian'];
        $tinhtrang      = "cxn";

        $conn->autocommit(FALSE);

        $donhang = "INSERT INTO donhang (idkh, tongtienhang, phivanchuyen, hoten, sdt, matp, maqh, xaid, diachi, note, matt)
                    VALUES ('$idkh', '$tongtienhang', '$phivanchuyen', '$hoten', '$sdt', '$matp', '$maqh', '$xaid', '$diachi', '$note', '$tinhtrang')";
        $result = $conn->query($donhang);

        $madh = $conn->insert_id;

        $themthoigian = $conn->query("INSERT INTO donhangthoigian VALUES ('$madh', 'cxn', '$thoigian')");

        for ($i = 0; $i < count($giaban); $i++){
            $chitietdh = "INSERT INTO donhangchitiet (madh, idsp, giaban, masize, solg)
                          VALUES ('$madh', '$sanpham[$i]', '$giaban[$i]', '$kichthuoc[$i]', '$solg[$i]')";
            $result_ct = $conn->query($chitietdh);
        }
        
        if (!$result || !$themthoigian || !$result_ct) {
            echo '
            <div class="overlay">
                <div class="response">
                    <div style="text-align: center; padding: 20px;">
                        <a href="../checkout.php" class="material-icons close-btn" style="top: 0;">clear</a>
                        <p style="font-size: 25px; margin-bottom: 20px; font-weight: 600;">Ôi không! Đã có lỗi xảy ra</p>
                        <img src="../img/giphy.gif" alt="">
                        <p style="font-size: 20px; margin-top: 20px;">Vui lòng thử lại sau</a></p>
                    </div>
                </div>
            </div>
            ';
            $conn->rollback();
        } else {
            echo'
            <div class="overlay">
                <div class="response">
                    <div style="text-align: center; padding: 20px;">
                        <a href="../index.php" class="material-icons close-btn" style="top: 0;">clear</a>
                        <p style="font-size: 25px; margin-bottom: 25px; font-weight: 600;">Đã đặt hàng thành công</p>
                        <img src="../img/check-circle.gif" alt="">
                        <p style="font-size: 20px; margin-top: 10px;">Theo dõi tình trạng đơn hàng <a href="../khachhang/ordered-details.php?madh='.$madh.'" style="color: rgb(70, 139, 243)">tại đây</a></p>
                    </div>
                </div>
            </div>
            ';
            $conn->commit();
            unset($_SESSION['cart']);
        }
    } else {
        header("location: ../index.php");
    }
    $conn->close();
?>
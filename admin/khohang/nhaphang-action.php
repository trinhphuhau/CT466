<?php
    require ("../connect.php");
    session_start();

    // print_r($_GET['oldproduct']);
    // print_r($_GET['newproduct']);
    $masize_array = array();
    $tgsolg = 0;
    // $sanpham_id = array();
    // $sanpham_solg = array();
    // $i = 0;
    // $conn->autocommit(FALSE);

    $kichthuoc = $conn->query("SELECT * FROM kichthuoc");
    while($row_kichthuoc = $kichthuoc->fetch_assoc()) {
      $masize_array[] = $row_kichthuoc["masize"];
    }

    if (isset($_GET['oldproduct'])) {
      $oldproduct = $_GET['oldproduct'];
      for ($n = 0; $n < count($masize_array); $n++) {
        for($i = 0; $i < count($_GET['oldproduct']['idsp']); $i++) {
          $op = $conn->query("UPDATE khohang
                              SET khohang.solg = khohang.solg + ".$oldproduct[$masize_array[$n]][$i].",
                                  khohang.sohgton = khohang.sohgton + ".$oldproduct[$masize_array[$n]][$i]."
                              WHERE idsp = '".$oldproduct['idsp'][$i]."'
                                AND masize = '".$masize_array[$n]."'");
          $tgsolg += $oldproduct[$masize_array[$n]][$i];
        }
      }
    }

    // if (isset($_GET['newproduct'])) {
    //   $newproduct = $_GET['newproduct'];
    //   $themsp = $conn->query("INSERT INTO sanpham (ten, hinhanh, tinhtrang, dateadded)
    //                           VALUES ('".$newproduct['ten'][$j]."', 'img/cloth.png', '0', '')");
    //   $sanpham_id = array();
    //   $idsp = $conn->insert_id;
    //   $sanpham_id[$i] = $idsp;
    //   for ($n = 0; $n < count($masize_array); $n++) {
    //     for($j = 0; $j < count($_GET['newproduct']['ten']); $j++) {
    //       if ($newproduct['solg'][$j] != 0) {
              
    //           $sanpham_solg[$i] = $newproduct['solg'][$j];
    //           $sm = $conn->query("INSERT INTO khohang
    //                               VALUES ('$idsp', '".$newproduct['solg'][$j]."', '".$newproduct['solg'][$j]."')");
    //       }
    //     }
    //   }
    // }

    $madonnhap = $_GET['madonnhap'];
    $thoigiannhap = $_GET['thoigiannhap'];
    $donnhap = $conn->query("INSERT INTO donnhap (madonnhap, tgsolg, thoigiannhap) VALUES ('$madonnhap', '$tgsolg', '$thoigiannhap')");
    $idnhap = $conn->insert_id;
    for ($n = 0; $n < count($masize_array); $n++) {
      for ($i = 0; $i < count($_GET['oldproduct']['idsp']); $i++) {
        $donnhapchitiet = $conn->query("INSERT INTO donnhapchitiet (idnhap, madonnhap, idsp, masize, solg)
                                        VALUES ('$idnhap', '$madonnhap', '".$oldproduct['idsp'][$i]."', '".$masize_array[$n]."', '".$oldproduct[$masize_array[$n]][$i]."')");
      // echo "INSERT INTO donnhapchitiet (madonnhap, idsp, masize, solg)
      //       VALUES ('$madonnhap', '".$oldproduct['idsp'][$i]."', '".$masize_array[$n]."', '".$oldproduct[$masize_array[$n]][$i]."')";
      }
    }

    // if (isset($_GET['sachcu'])) {
    //     if ($sc) {
    //         $conn->rollback();
    //         $_SESSION['message--success'] = 'window.alert("Thất bại, đã có lỗi xảy ra!");';
    //     }
    // } else if (isset($_GET['newproduct'])) {
    //     if (!$themsach || !$sm) {
    //         $conn->rollback();
    //         $_SESSION['message--success'] = 'window.alert("Thất bại, đã có lỗi xảy ra!");';
    //     }
    // } else if (isset($_GET['sachcu']) && isset($_GET['newproduct'])) {
    //     if (!$sc || !$themsach || !$sm) {
    //         $conn->rollback();
    //         $_SESSION['message--success'] = 'window.alert("Thất bại, đã có lỗi xảy ra!");';
    //     }
    // } else {
    //     $conn->commit();
    //     $_SESSION['message--success'] = 'window.alert("Đã nhập hàng thành công.");';
    // }
    // $_SESSION['message--nhaphang'] = 'window.alert("Đã nhập hàng thành công.");';
    header("location: nhaphang.php");
?>
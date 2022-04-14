<?php
    require ("../connect.php");
    session_start();
    if(isset($_SESSION["cart"])) {
        $i = $_GET["stt"];
        unset($_SESSION["cart"][$i]);
        $_SESSION["cart"] = array_values($_SESSION["cart"]);
        for($j = $i; $j < count($_SESSION["cart"]); $j++) {
            $_SESSION["cart"][$i] = $_SESSION["cart"][$j];
            $i++;
        }
        if (count($_SESSION["cart"]) == 0) {
            unset($_SESSION["cart"]);
        }
        // echo '<span class="cart-noti">Đã xóa sản phẩm thành công!</span>';
    }
    $conn->close();
?>
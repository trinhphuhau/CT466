<?php
    require ("../connect.php");
    session_start();
    if(!isset($_SESSION["cart"])) {
        $_SESSION["cart"][0]["idsp"] = $_GET['idsp'];
        $_SESSION["cart"][0]["soluong"] = 1;
        $_SESSION["cart"][0]["kichthuoc"] = $_GET["size"];
        echo '
        <span class="cart-noti">Thêm vào giỏ hàng thành công!</span>
        ';
    } else {
        $check = "";
        for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["idsp"] == $_GET["idsp"] && $_SESSION["cart"][$i]["kichthuoc"] == $_GET["size"]) {
                $_SESSION["cart"][$i]["soluong"]++;
                echo '
                <span class="cart-noti">Thêm vào giỏ hàng thành công!</span>
                ';
                $check = "1";
            }
        }
        if ($check != "1") {
            $j = count($_SESSION["cart"]);
            $_SESSION["cart"][$j]["idsp"] = $_GET["idsp"];
            $_SESSION["cart"][$j]["soluong"] = 1;
            $_SESSION["cart"][$j]["kichthuoc"] = $_GET["size"];
            echo '
            <span class="cart-noti">Thêm vào giỏ hàng thành công!</span>
            ';
        }
    }
    $conn->close();
?>
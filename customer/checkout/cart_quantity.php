<?php 
    require ("../connect.php");
    session_start();
    if(isset($_SESSION["cart"][$_GET["stt"]])) {
        $tongtien = 0;
        $_SESSION["cart"][$_GET["stt"]]["soluong"] = $_GET["solg"];
        for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
            $sql = "SELECT giaban FROM sanpham WHERE idsp = '".$_SESSION["cart"][$i]["idsp"]."'";
            $total = $conn->query($sql);
            $row_total = $total->fetch_assoc();
            $tongtien += $row_total["giaban"]*$_SESSION["cart"][$i]["soluong"];
        }
        echo "".number_format($tongtien,0,",",".")."₫";
    }
    $conn->close();
?>
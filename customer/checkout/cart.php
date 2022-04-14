<?php
    require ("../connect.php");
    session_start();
    $tongtien = 0;
?>
    <div id="cart-title-sticky">
        <h1 class="form-title">Shopping Cart</h1>
        <span class="material-icons close-btn" onclick="openCart()" style="top: -2px;">clear</span>
    </div>
    <div class="cart-container" id="cart-container">
<?php
    if (isset($_SESSION["cart"])) {
        // $_SESSION["cart"] = array_filter($_SESSION["cart"]);
        $solg = count($_SESSION["cart"])-1;
        for ($i = $solg; $i >= 0; $i--) {
            $idsp = $_SESSION["cart"][$i]["idsp"];
            $solg = $_SESSION["cart"][$i]["soluong"];
            $size = $_SESSION["cart"][$i]["kichthuoc"];
            $sanpham = $conn->query("SELECT * FROM sanpham WHERE idsp = '$idsp'");
            $row_sanpham = $sanpham->fetch_assoc();
            $tongtien += $row_sanpham["giaban"];
        ?>
        <div class="cart-product border-btm">
            <img src="<?php echo $row_sanpham["hinhanh"] ?>" alt="<?php echo $row_sanpham["ten"] ?>" class="cart-product__img">
            <div class="cart-product-info">
                <div>
                    <p class="cart-product__name"><?php echo $row_sanpham["ten"] ?></p>
                    <p class="cart-product__price">Price: <?php echo number_format($row_sanpham["giaban"],0,",",".") ?>₫</p>
                    <p class="cart-product__size">Size: <?php echo $size ?></p>
                </div>
                <div class="cart-product__quantity">
                    <!-- <span>Quantity:</span> -->
                    <span onclick="changeQuanlity(-1, <?php echo $i ?>)" class="quantity-btn">-</span>
                    <input type="number" id="product-quantity<?php echo $i ?>" value="<?php echo $solg ?>" onchange="quanlity(<?php echo $i ?>);">
                    <span onclick="changeQuanlity(+1, <?php echo $i ?>)" class="quantity-btn">+</span>
                </div>
            </div>
            <span class="material-icons cart-product__delete" onclick="delete_on(<?php echo $i ?>)">delete</span>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    </div>
    <div class="cart-btm">
        <div class="cart-total flex between">
            <span>Subtotal:</span>
            <span class="f-w600" id="cart-total"><?php echo number_format($tongtien,0,",",".") ?>₫</span>
        </div>
        <a href="<?php if(!isset($_SESSION["idkh"])) echo 'javascript: dangNhap_require();'; else echo '../checkout/checkout.php'; ?>" class="cart-submit<?php if(!isset($_SESSION["cart"])) echo " disabled-a"; ?>">Check Out</a>
    </div>
    <?php
    $conn->close();
?>
<?php
    require ("../connect.php");
    session_start();
    if (!isset($_SESSION["idkh"]) || !isset($_SESSION["cart"])) {
        header("location: ../index.php");
    }

    if (isset($_GET["signout"]) && isset($_SESSION["idkh"])) {
        unset ($_SESSION["idkh"]);
        $url = $_GET["redirect"];
        header("location: $url");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div id="response">
        <!-- <div class="overlay">
            <div class="response">
                <div style="text-align: center; padding: 20px;">
                    <a href="../index.php" class="material-icons close-btn" style="top: 0;">clear</a>
                    <p style="font-size: 25px; margin-bottom: 25px; font-weight: 600;">Đã đặt hàng thành công</p>
                    <img src="../..\img\check-circle.gif" alt="">
                    <p style="font-size: 20px; margin-top: 10px;">Theo dõi tình trạng đơn hàng <a href="../#" style="color: rgb(70, 139, 243)">tại đây</a></p>
                </div>
                <div style="text-align: center; padding: 20px;">
                    <a href="../order.html" class="material-icons close-btn" style="top: 0;">clear</a>
                    <p style="font-size: 25px; margin-bottom: 20px; font-weight: 600;">Ôi không! Đã có lỗi xảy ra</p>
                    <img src="../..\img\giphy.gif" alt="">
                    <p style="font-size: 20px; margin-top: 20px;">Vui lòng thử lại sau</a></p>
                </div>
            </div>
        </div> -->
    </div>
    <div class="header">
        <div class="navigation">
            <a href="javascript: openListSmallDevice()" class="nav-list">
                <span class="material-icons" style="font-size: 45px;" id="listIcon">menu</span>
            </a>
            <div class="navigation-link" id="linknenenene">
                <ul class="menu">
                    <li class="list-menu">
                        <div class="dropdown-menu" id="male-menu">
                            <a href="../index.php" class="list-title f-w600">The Fashion World</a>
                        </div>
                    </li>
                    <li class="list-menu">
                        <div class="dropdown-menu" id="male-menu">
                            <a href="../male-fashion.php" class="list-title">Men</a>
                            <div class="list-container">
                                <div class="list-grid">
                                    <div>
                                        <div class="clothes">Top</div>
                                        <ul>
                                            <?php
                                            $ao = $conn->query("SELECT * FROM loai WHERE loai = 'Top' AND gioitinh IN (0, 2)");
                                            while ($row_ao = $ao->fetch_assoc()) {?>
                                            <a href="../male-fashion.php?type=<?php echo $row_ao["maloai"] ?>">
                                                <li><?php echo $row_ao["tenloai"]; ?></li>
                                            </a>
                                            <?php    }
                                            ?>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="clothes">Bottom</div>
                                        <ul>
                                            <?php
                                            $quan = $conn->query("SELECT * FROM loai WHERE loai = 'Bottom' AND gioitinh IN (0, 2)");
                                            while ($row_quan = $quan->fetch_assoc()) {?>
                                            <a href="../male-fashion.php?type=<?php echo $row_quan["maloai"] ?>">
                                                <li><?php echo $row_quan["tenloai"]; ?></li>
                                            </a>
                                            <?php    }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-menu">
                        <div class="dropdown-menu" id="male-menu">
                            <a href="../female-fashion.php" class="list-title">Women</a>
                            <div class="list-container">
                                <div class="list-grid">
                                    <div>
                                        <div class="clothes">Top</div>
                                        <ul>
                                            <?php
                                            $ao = $conn->query("SELECT * FROM loai WHERE loai = 'Top' AND gioitinh IN (0, 1)");
                                            while ($row_ao = $ao->fetch_assoc()) {?>
                                            <a href="../female-fashion.php?type=<?php echo $row_ao["maloai"] ?>">
                                                <li><?php echo $row_ao["tenloai"]; ?></li>
                                            </a>
                                            <?php    }
                                            ?>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="clothes">Bottom</div>
                                        <ul>
                                            <?php
                                            $quan = $conn->query("SELECT * FROM loai WHERE loai = 'Bottom' AND gioitinh IN (0, 1)");
                                            while ($row_quan = $quan->fetch_assoc()) {?>
                                            <a href="../female-fashion.php?type=<?php echo $row_quan["maloai"] ?>">
                                                <li><?php echo $row_quan["tenloai"]; ?></li>
                                            </a>
                                            <?php    }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-menu">
                        <div class="dropdown-menu new-products">
                            <a href="../#new-products" class="list-title">What's new?</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- <div class="logo">
                <a href="../index.php"><img src="../img/logo.png" alt="Logo"></a>
            </div> -->
            <div class="navigation-user">
                <ul>
                    <li onclick="openSearch()" id="searchIcon">
                        <span class="material-icons md-36">search</span>
                    </li>
                    <li onclick="openLoginForm()" id="accountIcon">
                        <span class="material-icons md-36">person</span>
                    </li>
                    <li onclick="openCart()" id="cartIcon">
                        <span class="material-icons md-36" id="badge">shopping_cart</span>
                        <div class="badge" id="badge-cart">0</div>
                    </li>
                </ul>
            </div>
            <div>
                <div class="user_navigation" id="search">
                    <span class="material-icons close-btn" onclick="openSearch()">clear</span>
                    <div class="search-bar">
                        <form action="search.php?s=" method="get">
                            <input type="text" name="search" placeholder="What are you looking for?" class="search-bar__input" onkeyup="searchLive(this.value)" autocomplete="off"/>
                            <input type="submit" class="hide">
                        </form>
                    </div>
                    <div class="search-container">                             
                        <ul class="flex" style="justify-content: center;" id="livesearch"></ul>
                    </div>
                </div>
                <div class="user_navigation" id="account">
                    <span class="material-icons close-btn" onclick="openLoginForm()">clear</span>
                    <?php
                        if(!isset($_SESSION["idkh"])) { ?>
                            <div id="signUp">
                                <h1 class="form-title">Sign in</h1>
                                <div class="form-account" id="loginForm">
                                    <input type="text" id="username" placeholder="Username or phone number">
                                    <p class="error-form" id="username-error"></p>
                                    <input type="password" id="password" placeholder="Password">
                                    <p class="error-form" id="error"></p>
                                    <input type="hidden" id="redirect" name="redirect" value="<?php echo $url ?>">
                                    <input type="submit" id="signin-submit" value="Login">
                                </div>
                                <div class="form-account-a">Don't have an account yet? <a href="javascript: changeLoginForm();">Create one!</a></div>
                            </div>
                            <div class="hide" id="createUser">
                                <h1 class="form-title">Sign up</h1>
                                <form action="../khachhang/signup.php" method="post" class="form-account" name="createAccountForm" onsubmit="return createAccountValidateForm()" autocomplete="off">
                                    <input type="text" name="fullname" placeholder="Full Name">
                                    <p class="error-form" id="creat_fullname-error"></p>
                                    <input type="text" name="username" placeholder="Username" onchange="username_check(this.value);">
                                    <p class="error-form" id="creat_username-error"></p>
                                    <input type="password" name="password" placeholder="Password" onkeyup="password_type();">
                                    <p class="error-form" id="creat_password-error"></p>
                                    <input type="password" name="password2" placeholder="Confirm Password" onchange="password_check();" disabled="true">
                                    <p class="error-form" id="creat_password2-error"></p>
                                    <input type="text" name="sdt" placeholder="Phone Number">
                                    <p class="error-form" id="creat_sdt-error"></p>
                                    <input type="hidden" name="redirect" value="<?php echo $url ?>">
                                    <input type="submit" value="Create Account">
                                </form>
                                <div class="form-account-a">You already have an account? <a href="javascript: changeLoginForm();">Sign in</a></div>
                            </div>
                        <?php } else {
                            $khachhang = $conn->query("SELECT * FROM khachhang WHERE idkh = ".$_SESSION['idkh']."");
                            $row_khachhang = $khachhang->fetch_assoc(); ?>
                            <div id="signUp">
                            <h1 class="form-title">Your profile</h1>
                            <div class="form-account">
                                <label for="tendangnhap">Username</label>
                                <input type="text" id="username" name="hoten" value="<?php echo $row_khachhang["username"]; ?>" disabled="true">
                                <label for="name">Full Name</label>
                                <input type="text" id="hoten" name="hoten" placeholder="Name" value="<?php echo $row_khachhang["hoten"]; ?>">
                                <label for="name">Phone Number</label>
                                <input type="text" id="sdt" name="sdt" placeholder="Phone number" value="<?php echo $row_khachhang["sdt"]; ?>">
                                <p class="error-form" id="sdt-error"></p>
                                <label for="name">Address</label>
                                <input type="text" id="diachi" name="diachi" placeholder="House number, street name,..." value="<?php echo $row_khachhang["diachi"]; ?>">
                                <select name="tinhtp" id="tinhtp" onchange="quanhuyen(this.value)">
                                    <option value="">City</option>
                                    <?php
                                        $tinhtp = $conn->query("SELECT * FROM tinhthanhpho");
                                        while ($row_tinhtp = $tinhtp->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_tinhtp["matp"] ?>"<?php if ($row_khachhang["matp"] == $row_tinhtp["matp"]) echo "selected"; ?>><?php echo $row_tinhtp["name"] ?></option>
                                    <?php    }
                                    ?>
                                </select>
                                <select name="quanhuyen" id="quanhuyen" onchange="xaphuong(this.value)">
                                    <option value="">District</option>
                                    <?php
                                        $quanhuyen = $conn->query("SELECT * FROM quanhuyen WHERE matp = '".$row_khachhang["matp"]."'");
                                        while ($row_qh = $quanhuyen->fetch_assoc()) { ?>
                                        <option value="<?php echo $row_qh["maqh"]; ?>"<?php if ($row_khachhang["maqh"] == $row_qh["maqh"]) echo "selected"; ?>><?php echo $row_qh["name"]; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="xaphuongtt" id="xaphuongtt">
                                    <option value="">Commune/Ward/Townlet</option>
                                    <?php
                                        $xaphuong = $conn->query("SELECT * FROM xaphuongthitran WHERE maqh = '".$row_khachhang["maqh"]."'");
                                        while ($row_xp = $xaphuong->fetch_assoc()) { ?>
                                        <option value="<?php echo $row_xp["xaid"]; ?>"<?php if ($row_khachhang["xaid"] == $row_xp["xaid"]) echo "selected"; ?>><?php echo $row_xp["name"]; ?></option>
                                    <?php } ?>
                                </select>
                                <p class="error-form" id="change_info-error"></p>
                                <input type="submit" id="change_info-submit" value="Update Your Profile">
                                <a href="../khachhang/ordered-history.php" class="signout">Order History</a>
                                <a href="javascript: changeLoginForm();" class="signout">Change Password</a>
                                <a href="?redirect=<?php echo $url ?>&signout" class="signout">Sign Out</a>
                            </div>
                        </div>
                        <div class="hide" id="createUser">
                            <h1 class="form-title">Change Password</h1>
                            <div class="form-account">
                                <label for="old_pw">Current Password</label>
                                <input type="password" name="old_pw" id="old_pw" placeholder="Enter your current password">
                                <p class="error-form" id="old_pw-error"></p>
                                <label for="new_pw">New Password</label>
                                <input type="password" name="new_pw" id="new_pw" placeholder="Your new password" onkeyup="changepassword_type()">
                                <p class="error-form" id="new_pw-error"></p>
                                <input type="password" name="new_pw2" id="new_pw2" placeholder="Confirm password" disabled="true">
                                <p class="error-form" id="new_pw2-error"></p>
                                <input type="submit" id="change_pw-submit" value="Change Password">
                            </div>
                            <a href="javascript: changeLoginForm();" class="signout">Return</a>
                        </div>
                    <?php    }?>
                </div>
                <div class="user_navigation" id="cart">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <h1 class="nav-title">Check Out</h1>
        </div>
            <div class="container thanhtoan">
            <div class="order-details">
                <h1 class="border-btm">Order Details</h1>
                <div>
                    <div class="flex between border-btm">
                        <span>Item(s): <?php if (isset($_SESSION["cart"])) { echo count($_SESSION["cart"]); } ?></span>
                        <!-- <span class="thanhtien f-w600">Subtotal</span> -->
                    </div>
                    <?php
                        $tongtien = 0;
                        if (isset($_SESSION["cart"])) {
                        for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
                            $idsp = $_SESSION["cart"][$i]["idsp"];
                            $solg = $_SESSION["cart"][$i]["soluong"];
                            $size = $_SESSION["cart"][$i]["kichthuoc"];
                            $sanpham = $conn->query("SELECT * FROM sanpham WHERE idsp = '$idsp'");
                            $row_sanpham = $sanpham->fetch_assoc();
                            $tongtien = $tongtien + $row_sanpham["giaban"]*$solg;
                    ?>
                        <div class="flex between border-btm" style="margin-top: 10px;">
                            <div class="cart-product order-product">
                                <img src="<?php echo $row_sanpham["hinhanh"] ?>" alt="<?php echo $row_sanpham["ten"] ?>" class="cart-product__img">
                                <div class="cart-product-info">
                                    <div>
                                        <p class="cart-product__name"><?php echo $row_sanpham["ten"] ?></p>
                                        <p class="cart-product__price">Price: <span class="f-w600"><?php echo number_format($row_sanpham["giaban"],0,",",".") ?>₫</span></p>
                                        <p class="cart-product__size">Size: <span class="f-w600"><?php echo $size ?></span></p>
                                    </div>
                                    <div class="cart-product__quantity">
                                        <p class="cart-product__quantity">Quantity: <span class="f-w600"><?php echo $solg ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="thanhtien">
                                <span class="f-w600"><?php echo number_format($row_sanpham["giaban"]*$_SESSION["cart"][$i]["soluong"],0,",",".") ?>₫</span>
                            </div>
                        </div>
                    <?php }
                    } ?>
                    <div class="flex between border-btm">
                        <span>Subtotal:</span>
                        <span class="f-w600"><?php echo number_format($tongtien,0,",",".") ?>₫</span>
                    </div>
                    <div class="flex between border-btm">
                        <span>Shipping fee:</span>
                        <span class="f-w600">35.000₫</span>
                    </div>
                    <div class="flex between" style="padding: 10px 10px 0px 10px;">
                        <span class="f-w600">Total:</span>
                        <span class="f-w600"><?php echo number_format($tongtien+35000,0,",",".") ?>₫</span>
                    </div>
                    <!-- <input type="submit" value="Tiếp tục lựa sản phẩm mới" id="order-submit"> -->
                </div>
            </div>
            <div class="order">
                <h1 class="border-btm">Delivery Information</h1>
                <div class="order-info" id="order-info">
                    <div class="order-info-hoten_sdt">
                        <div>
                            <label for="hoten">Full Name</label><br>
                            <input type="text" name="hoten" id="hoten-order" value="<?php echo $row_khachhang["hoten"]; ?>" placeholder="Name" onkeyup="delError('hoten-order-error')">
                            <span class="error-order" id="hoten-order-error"></span>
                        </div>
                        <div>
                            <label for="sdt">Phone Number</label><br>
                            <input type="text" name="sdt" id="sdt-order" value="<?php echo $row_khachhang["sdt"]; ?>" placeholder="Phone number" onkeyup="delError('sdt-order-error')">
                            <span class="error-order" id="sdt-order-error"></span>
                        </div>
                    </div>
                    <div>
                        <label for="diachi">Delivery Address</label><br>
                        <input type="text" id="diachi-order" name="diachi-order" value="<?php echo $row_khachhang["diachi"]; ?>" placeholder="House number, street name,..." onkeyup="delError('diachi-order-error')">
                    </div>
                    <span class="error-order" id="diachi-order-error"></span>
                    <select name="tinhtp-order" id="tinhtp-order" onchange="quanhuyen_order(this.value)">
                        <option value="">Tỉnh/Thành phố</option>
                        <?php
                            $tinhtp = $conn->query("SELECT * FROM tinhthanhpho");
                            while ($row_tinhtp = $tinhtp->fetch_assoc()) { ?>
                        <option value="<?php echo $row_tinhtp["matp"] ?>"<?php if ($row_khachhang["matp"] == $row_tinhtp["matp"]) echo "selected"; ?>><?php echo $row_tinhtp["name"] ?></option>
                        <?php    }
                        ?>
                    </select>
                    <span class="error-order" id="tinhtp-order-error"></span>
                    <select name="quanhuyen-order" id="quanhuyen-order" onchange="xaphuong_order(this.value)">
                        <option value="">Quận/Huyện</option>
                        <?php
                            $quanhuyen = $conn->query("SELECT * FROM quanhuyen WHERE matp = '".$row_khachhang["matp"]."'");
                            while ($row_qh = $quanhuyen->fetch_assoc()) { ?>
                            <option value="<?php echo $row_qh["maqh"]; ?>"<?php if ($row_khachhang["maqh"] == $row_qh["maqh"]) echo "selected"; ?>><?php echo $row_qh["name"]; ?></option>
                        <?php } ?>
                    </select>
                    <span class="error-order" id="quanhuyen-order-error"></span>
                    <select name="xaphuongtt-order" id="xaphuongtt-order" onchange="delError('xaphuongtt-order-error');">
                        <option value="">Xã phường/Thị trấn</option>
                        <?php
                            $xaphuong = $conn->query("SELECT * FROM xaphuongthitran WHERE maqh = '".$row_khachhang["maqh"]."'");
                            while ($row_xp = $xaphuong->fetch_assoc()) { ?>
                            <option value="<?php echo $row_xp["xaid"]; ?>"<?php if ($row_khachhang["xaid"] == $row_xp["xaid"]) echo "selected"; ?>><?php echo $row_xp["name"]; ?></option>
                        <?php } ?>
                    </select>
                    <span class="error-order" id="xaphuongtt-order-error"></span>
                    <div>
                        <label for="note">Note</label>
                        <br>
                        <textarea name="note" id="note-order" placeholder="Leave a note (if you want to)"></textarea>
                    </div>
                    <?php
                        $total = 0;
                        $sanpham = array();
                        $solg  = array();
                        $kichthuoc = array();
                        $giaban  = array();
                        for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
                            $idsp = $_SESSION["cart"][$i]["idsp"];
                            $sanpham[$i] = $idsp;
                            $solg[$i] = $_SESSION["cart"][$i]["soluong"];
                            $kichthuoc[$i] = $_SESSION["cart"][$i]["kichthuoc"];
                            $sql = "SELECT * FROM sanpham WHERE idsp = '$idsp'";
                            $result = $conn->query($sql);
                            while ($row_pd = $result->fetch_assoc()){
                                $total = $row_pd["giaban"]*$_SESSION["cart"][$i]["soluong"] + $total;
                                $subtotal = $row_pd["giaban"]*$_SESSION["cart"][$i]["soluong"];
                                $giaban[$i] = $row_pd["giaban"];
                            }
                        }
                    ?>
                    <input type="hidden" name="tongtienhang" id="tongtienhang" value="<?php echo $total ?>">
                    <input type="hidden" name="phivanchuyen" id="phivanchuyen" value="<?php echo 35000 ?>">
                    <input type="hidden" name="sanpham" id="sanpham" value="<?php echo implode(", ", (array_filter($sanpham))) ?>">
                    <input type="hidden" name="solg" id="solg" value="<?php echo implode(", ", (array_filter($solg))) ?>">
                    <input type="hidden" name="kichthuoc" id="kichthuoc" value="<?php echo implode(", ", (array_filter($kichthuoc))) ?>">
                    <input type="hidden" name="giaban" id="giaban" value="<?php echo implode(", ", (array_filter($giaban))) ?>">
                    <input type="hidden" name="time-order" id="time-order">
                    <input type="submit" value="Place Order" id="order-submit">
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="company">
            <h1>The Fashion World</h1>
            <div>Feel free to contact us</div>
            <ul class="social-media flex">
                <li><a href="http://facebook.com"><img src="../img/facebook.png" alt="Facebook"></a></li>
                <li><a href="http://instagram.com"><img src="../img/instagram.png" alt="Instagram"></a></li>
                <li><a href="http://twitter.com"><img src="../img/twitter.png" alt="Twitter"></a></li>
                <li><a href="http://tumblr.com"><img src="../img/tumblr.png" alt="Tumblr"></a></li>
            </ul>
        </div>
        <div class="address">
            <h1>Address</h1>
            <div style="margin-bottom: 20px;">Campus II, 3/2 street, Ninh Kieu district, Can Tho city, Vietnam</div>
            <h1>Phone</h1>
            <div>0123 456 789</div>
        </div>
    </div>
</body>
<script>
    document.getElementById("order-submit").addEventListener("click", function(){
        time();
        var hoten = document.getElementById("hoten-order").value;
        var sdt = document.getElementById("sdt-order").value;
        var diachi = document.getElementById("diachi-order").value;
        var tinhtp = document.getElementById("tinhtp-order").value;
        var quanhuyen = document.getElementById("quanhuyen-order").value;
        var xaphuongtt = document.getElementById("xaphuongtt-order").value;
        var tongtienhang = document.getElementById("tongtienhang").value;
        var phivanchuyen = document.getElementById("phivanchuyen").value;
        var sanpham = document.getElementById("sanpham").value;
        var solg = document.getElementById("solg").value;
        var giaban = document.getElementById("giaban").value;
        var kichthuoc = document.getElementById("kichthuoc").value;
        var thoigian = document.getElementById("time-order").value;
        var note = document.getElementById("note-order").value;

        var sdt_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g; 
        
        var ok1 = true;
        if (hoten == "" || hoten == null) {
            document.getElementById("hoten-order-error").innerHTML = "Enter full name!";
            ok1 = false;
        } else {
            document.getElementById("hoten-order-error").innerHTML = "";
            ok1 = true;
        }
        var ok2 = true;
        if (sdt == "" || sdt == null) {
            document.getElementById("sdt-order-error").innerHTML = "Enter phone number!";
            ok2 = false;
        } else if (sdt_regex.test(sdt) == false) {
            document.getElementById("sdt-order-error").innerHTML = "Invalid phone number!";
            ok2 = false;
        } else {
            document.getElementById("sdt-order-error").innerHTML = "";
            ok2 = true;
        }
        var ok3 = true;
        if (diachi == "" || diachi == null) {
            document.getElementById("diachi-order-error").innerHTML = "Enter delivery address!";
            ok3 = false;
        } else {
            document.getElementById("diachi-order-error").innerHTML = "";
            ok3 = true;
        }
        var ok4 = true;
        if (tinhtp == "" || tinhtp == null) {
            document.getElementById("tinhtp-order-error").innerHTML = "Please provide city";
            ok4 = false;
        } else {
            document.getElementById("tinhtp-order-error").innerHTML = "";
            ok4 = true;
        }
        var ok5 = true;
        if (quanhuyen == "" || quanhuyen == null) {
            document.getElementById("quanhuyen-order-error").innerHTML = "Please provide district";
            ok5 = false;
        } else {
            document.getElementById("quanhuyen-order-error").innerHTML = "";
            ok5 = true;
        }
        var ok6 = true;
        if (xaphuongtt == "" || xaphuongtt == null) {
            document.getElementById("xaphuongtt-order-error").innerHTML = "Please provide ward";
            ok6 = false;
        } else {
            document.getElementById("xaphuongtt-order-error").innerHTML = "";
            ok6 = true;
        }
        
        if (ok1 == true && ok2 == true && ok3 == true && ok4 == true && ok5 == true && ok6 == true)
        {
            var send = 'hoten='+hoten+'&sdt='+sdt+'&diachi='+diachi+'&matp='+tinhtp+'&maqh='+quanhuyen
                        +'&xaid='+xaphuongtt+'&note='+note+'&tongtienhang='+tongtienhang+'&phivanchuyen='+phivanchuyen
                        +'&sanpham='+sanpham+'&solg='+solg+'&giaban='+giaban+'&kichthuoc='+kichthuoc+'&thoigian='+thoigian;
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("response").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("POST", "order-action.php", true);
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp.send(send);
        }
    });

    function delError(id){
        document.getElementById(id).innerHTML = "";
    }

    function time() {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        document.getElementById('time-order').value = dateTime;
	}
    
    function quanhuyen_order(matp) {
        xaphuong_order();
        delError('tinhtp-order-error');
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("quanhuyen-order").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../quanhuyen.php?matp="+matp, true);
        xmlhttp.send();
    }

    function xaphuong_order(maqh) {
        delError('quanhuyen-order-error');
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("xaphuongtt-order").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../xaphuong.php?maqh="+maqh, true);
        xmlhttp.send();
    }
</script>
<script src="../js/javascript.js"></script>
</html>
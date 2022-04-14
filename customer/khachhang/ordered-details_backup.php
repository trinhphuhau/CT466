<?php
    require ("../connect.php");
    session_start();
    if (!isset($_SESSION["idkh"]) || !isset($_GET["madh"])) {
        header("location: ../index.php");
    }
    if (isset($_GET["signout"]) && isset($_SESSION["idkh"])) {
        unset ($_SESSION["idkh"]);
        $url = $_GET["redirect"];
        header("location: $url");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div id="response">
        <div class="overlay" id="delete_cart">
            <div class="confirm">
                <div class="cart-question">Are you sure you want to remove this product from cart?</div>
                <div class="flex">
                    <div class="cart-no"><a href="javascript: delete_off()">No</a></div>
                    <div class="cart-yes"><a href="#" id="delete_item">Yes</a></div>
                </div>
            </div>
        </div>
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
                            <a href="../male-fashion.php" class="list-title">Nam</a>
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
                            <a href="../female-fashion.php" class="list-title">Nữ</a>
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
                            <a href="../#new-products" class="list-title">Sản phẩm mới</a>
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
                            <input type="text" name="search" placeholder="Nhập tên hoặc từ khóa cần tìm..." class="search-bar__input" onkeyup="searchLive(this.value)" autocomplete="off"/>
                            <input type="submit" class="hide">
                        </form>
                    </div>
                    <div>                             
                        <ul class="flex" style="justify-content: center;" id="livesearch"></ul>
                    </div>
                </div>
                <div class="user_navigation" id="account">
                    <span class="material-icons close-btn" onclick="openLoginForm()">clear</span>
                    <?php
                        if(!isset($_SESSION["idkh"])) { ?>
                            <div id="signUp">
                                <h1 class="form-title">Đăng nhập</h1>
                                <div class="form-account" id="loginForm">
                                    <input type="text" id="username" placeholder="Tên đăng nhập/Số điện thoại">
                                    <p class="error-form" id="username-error"></p>
                                    <input type="password" id="password" placeholder="Mật khẩu">
                                    <p class="error-form" id="error"></p>
                                    <input type="hidden" id="redirect" name="redirect" value="<?php echo $url ?>">
                                    <input type="submit" id="signin-submit" value="Đăng nhập">
                                </div>
                                <div class="form-account-a">Bạn chưa có tài khoản? <a href="javascript: changeLoginForm();">Hãy tạo ngay</a></div>
                            </div>
                            <div class="hide" id="createUser">
                                <h1 class="form-title">Đăng ký</h1>
                                <form action="../khachhang/signup.php" method="post" class="form-account" name="createAccountForm" onsubmit="return createAccountValidateForm()" autocomplete="off">
                                    <input type="text" name="username" placeholder="Tên đăng nhập" onchange="username_check(this.value);">
                                    <p class="error-form" id="creat_username-error"></p>
                                    <input type="password" name="password" placeholder="Mật khẩu" onkeyup="password_type();">
                                    <p class="error-form" id="creat_password-error"></p>
                                    <input type="password" name="password2" placeholder="Xác nhận mật khẩu" onchange="password_check();" disabled="true">
                                    <p class="error-form" id="creat_password2-error"></p>
                                    <input type="text" name="sdt" placeholder="Số điện thoại">
                                    <p class="error-form" id="creat_sdt-error"></p>
                                    <input type="hidden" name="redirect" value="<?php echo $url ?>">
                                    <input type="submit" value="Tạo tài khoản">
                                </form>
                                <div class="form-account-a">Bạn đã có tài khoản? <a href="javascript: changeLoginForm();">Đăng nhập ngay</a></div>
                            </div>
                        <?php } else {
                            $khachhang = $conn->query("SELECT * FROM khachhang WHERE idkh = ".$_SESSION['idkh']."");
                            $row_khachhang = $khachhang->fetch_assoc(); ?>
                            <div id="signUp">
                            <h1 class="form-title">Thông tin cá nhân</h1>
                            <div class="form-account">
                                <label for="tendangnhap">Tên đăng nhập</label>
                                <input type="text" id="username" name="hoten" value="<?php echo $row_khachhang["username"]; ?>" disabled="true">
                                <label for="name">Họ và tên</label>
                                <input type="text" id="hoten" name="hoten" placeholder="Họ và tên" value="<?php echo $row_khachhang["hoten"]; ?>">
                                <label for="name">Số điện thoại</label>
                                <input type="text" id="sdt" name="sdt" placeholder="Số điện thoại" value="<?php echo $row_khachhang["sdt"]; ?>">
                                <p class="error-form" id="sdt-error"></p>
                                <label for="name">Địa chỉ cụ thể</label>
                                <input type="text" id="diachi" name="diachi" placeholder="Số nhà, tên đường,..." value="<?php echo $row_khachhang["diachi"]; ?>">
                                <select name="tinhtp" id="tinhtp" onchange="quanhuyen(this.value)">
                                    <option value="">Tỉnh/Thành phố</option>
                                    <?php
                                        $tinhtp = $conn->query("SELECT * FROM tinhthanhpho");
                                        while ($row_tinhtp = $tinhtp->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_tinhtp["matp"] ?>"<?php if ($row_khachhang["matp"] == $row_tinhtp["matp"]) echo "selected"; ?>><?php echo $row_tinhtp["name"] ?></option>
                                    <?php    }
                                    ?>
                                </select>
                                <select name="quanhuyen" id="quanhuyen" onchange="xaphuong(this.value)">
                                    <option value="">Quận/Huyện</option>
                                    <?php
                                        $quanhuyen = $conn->query("SELECT * FROM quanhuyen WHERE matp = '".$row_khachhang["matp"]."'");
                                        while ($row_qh = $quanhuyen->fetch_assoc()) { ?>
                                        <option value="<?php echo $row_qh["maqh"]; ?>"<?php if ($row_khachhang["maqh"] == $row_qh["maqh"]) echo "selected"; ?>><?php echo $row_qh["name"]; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="xaphuongtt" id="xaphuongtt">
                                    <option value="">Xã phường/Thị trấn</option>
                                    <?php
                                        $xaphuong = $conn->query("SELECT * FROM xaphuongthitran WHERE maqh = '".$row_khachhang["maqh"]."'");
                                        while ($row_xp = $xaphuong->fetch_assoc()) { ?>
                                        <option value="<?php echo $row_xp["xaid"]; ?>"<?php if ($row_khachhang["xaid"] == $row_xp["xaid"]) echo "selected"; ?>><?php echo $row_xp["name"]; ?></option>
                                    <?php } ?>
                                </select>
                                <p class="error-form" id="change_info-error"></p>
                                <input type="submit" id="change_info-submit" value="Cập nhật thông tin">
                                <a href="../khachhang/ordered-history.php" class="signout">Xem lịch sử mua hàng</a>
                                <a href="javascript: changeLoginForm();" class="signout">Đổi mật khẩu</a>
                                <a href="?redirect=<?php echo $url ?>&signout" class="signout">Đăng xuất</a>
                            </div>
                        </div>
                        <div class="hide" id="createUser">
                            <h1 class="form-title">Đổi mật khẩu</h1>
                            <div class="form-account">
                                <label for="old_pw">Mật khẩu cũ</label>
                                <input type="password" name="old_pw" id="old_pw" placeholder="Nhập mật khẩu cũ">
                                <p class="error-form" id="old_pw-error"></p>
                                <label for="new_pw">Mật khẩu mới</label>
                                <input type="password" name="new_pw" id="new_pw" placeholder="Nhập mật khẩu mới" onkeyup="changepassword_type()">
                                <p class="error-form" id="new_pw-error"></p>
                                <input type="password" name="new_pw2" id="new_pw2" placeholder="Xác nhận mật khẩu" disabled="true">
                                <p class="error-form" id="new_pw2-error"></p>
                                <input type="submit" id="change_pw-submit" value="Đổi mật khẩu">
                            </div>
                            <a href="javascript: changeLoginForm();" class="signout">Trở lại</a>
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
            <h1 class="nav-title">Chi tiết đơn hàng</h1>
        </div>
        <div class="container">
            <div class="order-history-grid">
                <div class="order-history-col1">
                    <div class="order-history-nav">
                    <a href="../khachhang/ordered-history.php" class="flex" style="align-items: center; gap: 10px">
                        <span class="material-icons" style="font-size: 50px">arrow_back</span>
                        <span style="font-size: 30px">Quay trở lại</span>
                    </a>
                    </div>
                </div>
                <?php
                    $madh = $_GET["madh"];
                    $donhang = $conn->query("SELECT * FROM donhang dh, donhangtinhtrang dhtt
                                            WHERE dh.madh = '$madh' AND dh.matt = dhtt.matt");
                    $diachi = $conn->query("SELECT tp.name AS tinhtp, qh.name AS quanhuyen, tt.name thitran
                                            FROM donhang dh, tinhthanhpho tp, quanhuyen qh, xaphuongthitran tt
                                            WHERE dh.madh = '$madh' AND dh.matp = tp.matp AND dh.maqh = qh.maqh AND dh.xaid = tt.xaid");
                    $row_donhang = $donhang->fetch_assoc();
                    $row_diachi = $diachi->fetch_assoc();
                ?>
                <div class="order-history-col2" style="position: relative;">
                    <div class="order-history-details">
                        <div class="order_details">
                            <div class="flex between border-btm">
                                <span>Mã đơn hàng: <?php echo $row_donhang["madh"] ?></span>
                                <span class="f-w600"><?php echo $row_donhang["tinhtrang"] ?></span>
                            </div>
                            <div class="border-btm" style="line-height: 1.5">
                                <h2>Địa chỉ nhận hàng</h2>
                                <p>Họ và tên: <?php echo $row_donhang["hoten"] ?></p>
                                <p>Số điện thoại: <?php echo $row_donhang["sdt"] ?></p>
                                <p>Địa chỉ: <?php echo $row_donhang["diachi"] ?>, <?php echo $row_diachi["thitran"] ?>, <?php echo $row_diachi["quanhuyen"] ?>, <?php echo $row_diachi["tinhtp"] ?></p>
                            </div>
                            <?php
                            $chitietdh = $conn->query("SELECT * FROM donhangchitiet dhct, sanpham sp, donhang dh
                                                        WHERE dhct.madh = dh.madh
                                                        AND dhct.idsp = sp.idsp
                                                        AND dh.madh = '".$row_donhang["madh"]."'");
                            while ($row_chitietdh = $chitietdh->fetch_assoc()) { ?>
                            <div class="flex between border-btm" style="margin-top: 10px;">
                                <div class="cart-product order-product">
                                    <img src="<?php echo $row_chitietdh["hinhanh"] ?>" alt="<?php echo $row_chitietdh["ten"] ?>" class="cart-product__img">
                                    <div class="cart-product-info">
                                        <div>
                                            <p class="cart-product__name"><?php echo $row_chitietdh["ten"] ?></p>
                                            <p class="cart-product__size">Kích thước: <span><?php echo $row_chitietdh["masize"] ?></span></p>
                                            <p class="cart-product__price">Giá bán: <span><?php echo number_format($row_chitietdh["giaban"],0,",",".") ?>₫</span></p>
                                        </div>
                                        <div class="cart-product__quantity">
                                            <p class="cart-product__quantity">Số lượng: <span><?php echo $row_chitietdh["solg"] ?></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="thanhtien">
                                    <span><?php echo number_format($row_chitietdh["giaban"]*$row_chitietdh["solg"],0,",",".") ?>₫</span>
                                </div>
                            </div>
                            <?php }?>
                            <div class="ordered-info-last-row border-btm">
                                <?php
                                $thoigian = $conn->query("SELECT thoigian FROM donhangthoigian WHERE madh = '".$row_donhang["madh"]."' AND matt = 'cxn'");
                                $row_thoigian = $thoigian->fetch_assoc();
                                $date = date_create($row_thoigian["thoigian"]);
                                ?>
                                <div class="order-time">
                                    <span>Đơn hàng đã đặt</span>
                                    <span><?php echo date_format($date, "H:i d/m/Y") ?></span>
                                </div>
                                <?php

                                if ($row_donhang["matt"] != "dh") {
                                $thoigian = $conn->query("SELECT thoigian FROM donhangthoigian WHERE madh = '".$row_donhang["madh"]."' AND matt = 'clh'");
                                if ($thoigian->num_rows > 0) {
                                    $row_thoigian = $thoigian->fetch_assoc();
                                    $date = date_create($row_thoigian["thoigian"]);
                                ?>
                                <div class="order-time">
                                    <span>Đã xác nhận</span>
                                    <span><?php echo date_format($date, "H:i d/m/Y") ?></span>
                                </div>
                                <?php } ?>

                                <?php
                                $thoigian = $conn->query("SELECT thoigian FROM donhangthoigian WHERE madh = '".$row_donhang["madh"]."' AND matt = 'dvc'");
                                if ($thoigian->num_rows > 0) {
                                    $row_thoigian = $thoigian->fetch_assoc();
                                    $date = date_create($row_thoigian["thoigian"]);
                                ?>
                                <div class="order-time">
                                    <span>Giao cho vận chuyển</span>
                                    <span><?php echo date_format($date, "H:i d/m/Y") ?></span>
                                </div>
                                <?php } ?>

                                <?php
                                $thoigian = $conn->query("SELECT thoigian FROM donhangthoigian WHERE madh = '".$row_donhang["madh"]."' AND matt = 'ht'");
                                if ($thoigian->num_rows > 0) {
                                    $row_thoigian = $thoigian->fetch_assoc();
                                    $date = date_create($row_thoigian["thoigian"]);
                                ?>
                                <div class="order-time">
                                    <span>Đã nhận</span>
                                    <span><?php echo date_format($date, "H:i d/m/Y") ?></span>
                                </div>
                                <?php } ?>

                                <?php }
                                else {
                                    $thoigian = $conn->query("SELECT thoigian FROM donhangthoigian WHERE madh = '".$row_donhang["madh"]."' AND matt = 'dh'");
                                    if ($thoigian->num_rows > 0) {
                                        $row_thoigian = $thoigian->fetch_assoc();
                                        $date = date_create($row_thoigian["thoigian"]);
                                    } else $date = "0";
                                ?>
                                <div class="order-time">
                                    <span>Đã hủy</span>
                                    <span><?php if ($date != "0") echo date_format($date, "H:i d/m/Y") ?></span>
                                </div>
                                <?php }?>
                            </div>
                            <div class="ordered-info-last-row" style="padding: 10px 10px 0px 10px">
                                <div class="order-money">
                                    <span>Tiền hàng:</span>
                                    <span><?php echo number_format($row_donhang["tongtienhang"],0,",",".") ?>₫</span>
                                </div>
                                <div class="order-money">
                                    <span>Phí vận chuyển:</span>
                                    <span><?php echo number_format($row_donhang["phivanchuyen"],0,",",".") ?>₫</span>
                                </div>
                                <div class="order-money f-w600" style="font-size: 20px;">
                                    <span>Tổng số tiền:</span>
                                    <span><?php echo number_format($row_donhang["tongtienhang"]+$row_donhang["phivanchuyen"],0,",",".") ?>₫</span>
                                </div>
                            </div>
                            <?php
                                if ($row_donhang["matt"] == "cxn") {
                            ?>
                            <div style="margin-top: 15px;">
                                <form action="../khachhang/cancel-checkout.php" method="post" id="form_huydonhang">
                                    <input type="hidden" name="madh" value="<?php echo $madh ?>">
                                    <input type="hidden" name="thoigian" value="" id="thoigian">
                                    <input type="hidden" name="redirect" value="<?php echo $url ?>">
                                    <input type="submit" id="submit-hdh" style="display: none">
                                </form>
                                <a href="javascript:submit_hdh()" class="cancel-btn">Hủy đơn hàng</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
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
    function dateTime() {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        return dateTime;
    }

    function submit_hdh() {
        var thoigian = dateTime();
        document.getElementById('thoigian').value = thoigian;
        // document.getElementById('form_huydonhang').submit();
        document.getElementById('submit-hdh').click();
    }
</script>
<script src="../js/javascript.js"></script>
<script>
    //Đăng nhập
    var checkSignin = document.getElementById("signin-submit");
    if (checkSignin) {
        checkSignin.addEventListener("click", function(){
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var redirect = document.getElementById("redirect").value;
            if (username == "" || username == null) {
                document.getElementById("username-error").innerHTML = "Vui lòng nhập tài khoản!";
                document.getElementById("username-error").style = "margin-bottom: 10px;";
            }
            if (password == "" || password == null) {
                document.getElementById("error").innerHTML = "Vui lòng nhập mật khẩu!";
                document.getElementById("error").style = "margin-bottom: 10px;";
            }
            if (username != "" && password != "")
            {
                var send = 'username='+username+'&password='+password+'&redirect='+redirect;
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText != "0") {
                        document.getElementById("response").innerHTML = xmlhttp.responseText;
                        setTimeout('window.location.href = "<?php $url ?>"', 2000);
                    } else if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText == "0") {
                        document.getElementById("error").innerHTML = "Sai tài khoản hoặc mật khẩu!";
                        document.getElementById("error").style = "margin-bottom: 10px;";
                    }
                }
                xmlhttp.open("POST", "../khachhang/signin.php", true);
                xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xmlhttp.send(send);
            }
        }, false);
    }
</script>
</html>
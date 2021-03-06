<?php
    require ("connect.php");
    session_start();
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
    <title>The Fashion World</title>
    <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 2s;
            animation-name: fade;
            animation-duration: 2s;
            }

            @-webkit-keyframes fade {
            from {opacity: .4} 
            to {opacity: 1}
            }

            @keyframes fade {
            from {opacity: .4} 
            to {opacity: 1}
        }
    </style>
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
        <div class="banner-container">
            <span class="prev-btn" onclick="plusSlides(-1)">&#139;</span>
            <span class="next-btn" onclick="plusSlides(1)">&#155;</span>
            <div>
                <img src="../img/fashion1.jpg" alt="Fashion1" class="banner-img fade">
                <img src="../img/fashion2.jpg" alt="Fashion2" class="banner-img fade">
                <img src="../img/fashion3.jpg" alt="Fashion3" class="banner-img fade">
            </div>
            <div style="position: absolute; z-index: 2; top: 98%; left: 50%; transform: translate(-50%, -50%);">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>
        <div class="container" style="padding-top: 30px;">
            <h1 class="container-title">
                <span onclick="maleFashion()">Men's fashion</span> |
                <span onclick="femaleFashion()">Women's fashion</span>
            </h1>
            <div class="slide" id="maleFashion">
                <span id="prev-male">&#139;</span>
                <ul>
                <?php
                    $new_male = $conn->query("SELECT * FROM sanpham WHERE gioitinh = '2' ORDER BY idsp DESC LIMIT 9");
                    if ($new_male->num_rows > 0) {
                        while($row = $new_male->fetch_assoc()) { ?>
                    <li class="slide-product slide-male">
                        <a href="../product.php?id=<?php echo $row["idsp"] ?>">
                            <img src="<?php echo $row["hinhanh"] ?>" alt="<?php echo $row["ten"] ?>" class="slide-product-img">
                        </a>
                        <div class="slide-product-info">
                            <a href="../product.php?id=<?php echo $row["idsp"] ?>">
                                <div class="slide-product-name"><?php echo $row["ten"] ?></div>
                            </a>
                            <div class="slide-product-price"><?php echo number_format($row["giaban"],0,",",".") ?>???</div>
                        </div>
                    </li>
                <?php        }
                    }
                ?>
                </ul>
                <span id="next-male">&#155;</span>
            </div>
            <div class="slide" id="femaleFashion" style="display: none">
                <span id="prev-female">&#139;</span>
                <ul>
                <?php
                    $new_female = $conn->query("SELECT * FROM sanpham WHERE gioitinh = '1' ORDER BY idsp DESC LIMIT 9");
                    if ($new_female->num_rows > 0) {
                        while($row = $new_female->fetch_assoc()) { ?>
                    <li class="slide-product slide-female">
                        <a href="../product.php?id=<?php echo $row["idsp"] ?>">
                            <img src="<?php echo $row["hinhanh"] ?>" alt="<?php echo $row["ten"] ?>" class="slide-product-img">
                        </a>
                        <div class="slide-product-info">
                            <a href="../product.php?id=<?php echo $row["idsp"] ?>">
                                <div class="slide-product-name"><?php echo $row["ten"] ?></div>
                            </a>
                            <div class="slide-product-price"><?php echo number_format($row["giaban"],0,",",".") ?>???</div>
                        </div>
                    </li>
                <?php        }
                    }
                ?>
                </ul>
                <span id="next-female">&#155;</span>
            </div>
        </div>
        <div class="container">
            <h1 class="container-title" class="new-products" id="new-products">
                <span style="color: rgb(238, 49, 49);">THIS IS NEW!!!</span>
            </h1>
            <div class="slide">
                <span id="prev-new">&#139;</span>
                <ul>
                <?php
                    $new_male = $conn->query("SELECT * FROM sanpham ORDER BY idsp DESC LIMIT 9");
                    if ($new_male->num_rows > 0) {
                        while($row = $new_male->fetch_assoc()) { ?>
                    <li class="slide-product slide-new">
                        <a href="../product.php?id=<?php echo $row["idsp"] ?>">
                            <img src="<?php echo $row["hinhanh"] ?>" alt="<?php echo $row["ten"] ?>" class="slide-product-img">
                        </a>
                        <div class="slide-product-info">
                            <a href="../product.php?id=<?php echo $row["idsp"] ?>">
                                <div class="slide-product-name"><?php echo $row["ten"] ?></div>
                            </a>
                            <div class="slide-product-price"><?php echo number_format($row["giaban"],0,",",".") ?>???</div>
                        </div>
                    </li>
                <?php        }
                    }
                ?>
                </ul>
                <span id="next-new">&#155;</span>
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
    var slideIndex = 0;
    var slides = document.getElementsByClassName("banner-img");
    var dots = document.getElementsByClassName("dot");

    autoChangeSlides();

    function plusSlides(n) {showSlides(slideIndex += n);}
    function currentSlide(n) {showSlides(slideIndex = n);}
    function showSlides(n) {
        var i;
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
            dots[i].className = dots[i].className.replace(" dot-active", "");
        }
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " dot-active";
    }
    function autoChangeSlides() {
        var i;
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            dots[i].className = dots[i].className.replace(" dot-active", "");
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        if (slideIndex < 1) {slideIndex = slides.length}
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " dot-active";
        setTimeout(autoChangeSlides, 5000);
    }
</script>
<script>
    //Slide male
    var prev_new = document.getElementById('prev-new');
    var next_new = document.getElementById('next-new');
    var slide_new = document.getElementsByClassName('slide-new');
    var n = 0;
    next_new.onclick = ()=>{
        n++;
        for (var a of slide_new) {
            if (n == 0) {a.style.left = "0px";}
            if (n == 1) {a.style.left = "-400px";}
            if (n == 2) {a.style.left = "-800px";}
            if (n == 3) {a.style.left = "-1200px";}
            if (n > 4)  {n = 0; a.style.left = "0px";}
        }
    }

    prev_new.onclick = ()=>{
        n--;
        for (var a of slide_new) {
            if (n == 0) {a.style.left = "0px";}
            if (n == 1) {a.style.left = "-400px";}
            if (n == 2) {a.style.left = "-800px";}
            if (n == 3) {a.style.left = "-1200px";}
            if (n < 0)  {n = 4;}
        }
    }

    //Slide female
    var prev_female = document.getElementById('prev-female');
    var next_female = document.getElementById('next-female');
    var slide_female = document.getElementsByClassName('slide-female');
    var f = 0;
    next_female.onclick = ()=>{
        f++;
        for (var b of slide_female) {
            if (f == 0) {b.style.left = "0px";}
            if (f == 1) {b.style.left = "-400px";}
            if (f == 2) {b.style.left = "-800px";}
            if (f == 3) {b.style.left = "-1200px";}
            if (f > 4)  {f = 0; b.style.left = "0px";}
        }
    }
    prev_female.onclick = ()=>{
        f--;
        for (var b of slide_female) {
            if (f == 0) {b.style.left = "0px";}
            if (f == 1) {b.style.left = "-400px";}
            if (f == 2) {b.style.left = "-800px";}
            if (f == 3) {b.style.left = "-1200px";}
            if (f < 0) {f = 4;}
        }
    }

    //Slide male
    var prev_male = document.getElementById('prev-male');
    var next_male = document.getElementById('next-male');
    var slide_male = document.getElementsByClassName('slide-male');
    var m = 0;
    next_male.onclick = ()=>{
        m++;
        for (var c of slide_male) {
            if (m == 0) {c.style.left = "0px";}
            if (m == 1) {c.style.left = "-400px";}
            if (m == 2) {c.style.left = "-800px";}
            if (m == 3) {c.style.left = "-1200px";}
            if (m > 4)  {m = 0; c.style.left = "0px";}
        }
    }
    prev_male.onclick = ()=>{
        m--;
        for (var c of slide_male) {
            if (m == 0) {c.style.left = "0px";}
            if (m == 1) {c.style.left = "-400px";}
            if (m == 2) {c.style.left = "-800px";}
            if (m == 3) {c.style.left = "-1200px";}
            if (m < 0) {m = 4;}
        }
    }
    
    //Slide fashion
    function femaleFashion(){
        document.getElementById("maleFashion").style.display = "none";
        document.getElementById("femaleFashion").style.display = "flex";
    }
    
    function maleFashion(){
        document.getElementById("maleFashion").style.display = "flex";
        document.getElementById("femaleFashion").style.display = "none";
    }
</script>
<script src="../js/javascript.js"></script>
<script>
    //????ng nh???p
    var checkSignin = document.getElementById("signin-submit");
    if (checkSignin) {
        checkSignin.addEventListener("click", function(){
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var redirect = document.getElementById("redirect").value;
            if (username == "" || username == null) {
                document.getElementById("username-error").innerHTML = "Vui l??ng nh???p t??i kho???n!";
                document.getElementById("username-error").style = "margin-bottom: 10px;";
            }
            if (password == "" || password == null) {
                document.getElementById("error").innerHTML = "Vui l??ng nh???p m???t kh???u!";
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
                        document.getElementById("error").innerHTML = "Sai t??i kho???n ho???c m???t kh???u!";
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
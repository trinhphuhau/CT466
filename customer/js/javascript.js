var searchClick = 0;
var loginFormClick = 0;
var cartClick = 0;
var openListSmallDeviceClick = 0;
var loginForm = document.getElementById("account").style;
var cart = document.getElementById("cart").style;
var cartContainer;

var watchSearch = document.querySelectorAll("ul#livesearch > li");

var watchMedia = window.matchMedia("(max-width: 1024px)");

function watchAll() {
    if (cartClick%2 == 1) {
        if (!watchMedia.matches) {
            cart.width = "400px";
            cart.height = "550px";
        } else {
            cart.width = "100%";
            cart.height = "calc(100vh - 60px)";
        }
    }
    if (loginFormClick%2 == 1) {
        if (!watchMedia.matches) {
            loginForm.width = "350px";
        } else {
            loginForm.width = "100%";
        }
    }
    if (watchMedia.matches) {
        searchSmallDevice("small");
    } else {
        searchSmallDevice("large");
    }
}

function openCart(){
    cartClick++;
    if (cartClick%2 == 1) {
        if (window.matchMedia("(max-width: 1024px)").matches) {
            cart.width = "100%";
            cart.height = "calc(100vh - 60px)";
        } else  {
            cart.width = "400px";
            cart.minHeight = "550px";
        }
        // cart.width = "400px";
        checkClickCount(2);
        document.getElementById("cartIcon").classList.toggle("active");
    } else {
        cart.width = "0px";
        document.getElementById("cartIcon").classList.remove("active");
    }
}

function searchSmallDevice(str) {
    if (str == "small") {
        if (watchSearch.length >= 3) {
            for(var i = watchSearch.length-1; i > 1; i--) {
                watchSearch[i].style.display = "none";
            }
        }
    } else if (str == "large") {
        for(var i = watchSearch.length-1; i >= 0; i--) {
            watchSearch[i].style.display = "block";
        }
    }
}

watchAll();
watchMedia.addListener(watchAll);

function checkClickCount(pos) {
    if (pos == 0) {
        if (loginFormClick%2 == 1) {
            openLoginForm();
        } else if (cartClick%2 == 1) {
            openCart();
        } else if (openListSmallDeviceClick%2 == 1) {
            openListSmallDevice();
        }
    }
    if (pos == 1) {
        if (searchClick%2 == 1) {
            openSearch();
        } else if (cartClick%2 == 1) {
            openCart();
        } else if (openListSmallDeviceClick%2 == 1) {
            openListSmallDevice();
        }
    }
    if (pos == 2) {
        if (searchClick%2 == 1) {
            openSearch();
        } else if (loginFormClick%2 == 1) {
            openLoginForm();
        } else if (openListSmallDeviceClick%2 == 1) {
            openListSmallDevice();
        }
    }
    if (pos == 3) {
        if (searchClick%2 == 1) {
            openSearch();
        } else if (loginFormClick%2 == 1) {
            openLoginForm();
        } else if (cartClick%2 == 1) {
            openCart();
        }
    }
}

function openListSmallDevice() {
    openListSmallDeviceClick++;
    if (openListSmallDeviceClick%2 == 1) {
        document.getElementById("linknenenene").style.width = "100%";
        checkClickCount(3);
        document.getElementById("listIcon").classList.toggle("active");
        document.getElementById("listIcon").innerHTML = "close";
    } else {
        document.getElementById("linknenenene").style.width = "0";
        document.getElementById("listIcon").classList.remove("active");
        document.getElementById("listIcon").innerHTML = "menu";
    }
}

//Search
function openSearch(){
    searchClick++;
    var search = document.getElementById("search").style;
    if (searchClick%2 == 1) {
        search.height = "470px";
        checkClickCount(0);
        document.getElementById("searchIcon").classList.toggle("active");
    } else {
        search.height = "0";
        document.getElementById("searchIcon").classList.remove("active");
    }
}

//Account
function openLoginForm(){
    loginFormClick++;
    if (loginFormClick%2 == 1) {
        if (window.matchMedia("(max-width: 1024px)").matches) {
            loginForm.width = "100%";
        } else  {
            loginForm.width = "350px";
        }
        checkClickCount(1);
        document.getElementById("accountIcon").classList.toggle("active");
    } else {
        loginForm.width = "0px";
        document.getElementById("accountIcon").classList.remove("active");
    }
}

function changeLoginForm(){
    document.getElementById("signUp").classList.toggle("hide");
    document.getElementById("createUser").classList.toggle("show");
}

//Cart
function delete_on(stt) {
    document.getElementById("delete_cart").style.display = "block";
    document.getElementById("delete_item").setAttribute("href", "javascript: delete_yes("+stt+");");
}

function delete_off(){
    document.getElementById("delete_cart").style.display = "none";
}

function delete_yes(stt){
    document.getElementById("delete_cart").style.display = "none";
    setTimeout(removeFromCart(stt), 1000);
}

function closeCart(){
    cart.width = "0px";
    document.getElementById("cartIcon").classList.toggle("active");
}

function dangNhap_require() {
    window.alert("Please sign into your account!");
    closeCart();
    openLoginForm();
    document.getElementById("account").scrollIntoView();
}

searchLive("");
function searchLive(str) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
            watchSearch = document.querySelectorAll("ul#livesearch > li");
            watchAll();
        }
    }
    xmlhttp.open("GET","../livesearch.php?search=" + str,true);
    xmlhttp.send();
}

function quanhuyen(matp) {
    xaphuong();
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("quanhuyen").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "../quanhuyen.php?matp="+matp, true);
    xmlhttp.send();
}

function xaphuong(maqh) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("xaphuongtt").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "../xaphuong.php?maqh="+maqh, true);
    xmlhttp.send();
}

//Giỏ hàng
cartLive();
function cartLive() {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("cart").innerHTML = xmlhttp.responseText;
            var so =  document.querySelectorAll(".cart-container > div");
            document.getElementById("badge-cart").innerHTML = so.length;
            cartContainer = document.getElementsByClassName("cart-container").style;
        }
    }
    xmlhttp.open("GET", "../checkout/cart.php", true);
    xmlhttp.send();
}

function changeQuanlity(i, stt) {
    var vitriID = "product-quantity"+stt;
    var quantity = document.getElementById(vitriID);
    var current_quantity = parseInt(quantity.value);
    var solg = current_quantity + i;
    if (solg <= 0) {
        delete_on(stt);
    } else {
        quantity.value = solg;
        quanlity(stt);
    }
}

function quanlity(stt) {
    var vitriID = "product-quantity"+stt;
    var solg = document.getElementById(vitriID).value;
    var js = "?stt="+stt+"&solg="+solg;
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("cart-total").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "../checkout/cart_quantity.php"+js, true);
    xmlhttp.send();
}

function removeFromCart(stt) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // document.getElementById("cart-noti").innerHTML = xmlhttp.responseText;
            // setTimeout(function(){document.getElementById("cart-noti").innerHTML = ""}, 100000);
            cartLive();
        }
    }
    xmlhttp.open("GET", "../checkout/remove-cart.php?stt="+stt, true);
    xmlhttp.send();
}

var usernameListen = document.getElementById("username");
if (usernameListen) {
    usernameListen.addEventListener("change", function(){
    document.getElementById("username-error").innerHTML = "";
    document.getElementById("username-error").style = "margin-bottom: 0;";
    }, false);
}

//Tạo tài khoản
function createAccountValidateForm() {
    var form = document.forms["createAccountForm"];
    var fullname = form["fullname"].value;
    var username = form["username"].value;
    var password1 = form["password"].value;
    var password2 = form["password2"].value;

    var ok0 = false;
    if (fullname == "" || fullname == null) {
        document.getElementById("creat_fullname-error").innerHTML = "Enter full name";
        document.getElementById("creat_fullname-error").style = "margin-bottom: 10px;";
        ok0 = false;
    } else {
        document.getElementById("creat_fullname-error").innerHTML = "";
        document.getElementById("creat_fullname-error").style = "margin-bottom: 0;";
        ok0 = true;
    }
    
    var ok1 = false;
    if (username == "" || username == null) {
        document.getElementById("creat_username-error").innerHTML = "Enter your username";
        document.getElementById("creat_username-error").style = "margin-bottom: 10px;";
        ok1 = false;
    } else if (username != "" || username != null){
        ok1 = username_check(username);
    } else {
        ok1 = true;
    }

    var ok2 = false;
    if (password1 == "" || password1 == null) {
        document.getElementById("creat_password-error").innerHTML = "Enter password";
        document.getElementById("creat_password-error").style = "margin-bottom: 10px;";
        ok2 = false;
    } else {
        document.getElementById("creat_password-error").innerHTML = "";
        document.getElementById("creat_password-error").style = "margin-bottom: 0;";
        ok2 = true;
    }
    
    var ok3 = false;
    if (password2 == "" || password2 == null) {
        document.getElementById("creat_password2-error").innerHTML = "Enter password confirm";
        document.getElementById("creat_password2-error").style = "margin-bottom: 10px;";
        ok3 = false;
    } else if (password2 != "" || password2 != null) {
        ok3 = password_check();
    } else {
        document.getElementById("creat_password2-error").innerHTML = "";
        document.getElementById("creat_password2-error").style = "margin-bottom: 0;";
        ok3 = true;
    }
    
    if (ok0 == true && ok1 == true && ok2 == true && ok3 == true)
        return true;
    else
        return false;
}

function username_check(str) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange  = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText == "0") {
            document.getElementById("creat_username-error").innerHTML = "Username has already been taken";
            document.getElementById("creat_username-error").style = "margin-bottom: 10px;";
            return false;
        } else {
            document.getElementById("creat_username-error").innerHTML = "";
            document.getElementById("creat_username-error").style = "margin-bottom: 0;";
            return true;
        }
    }
    xmlhttp.open("GET", "../khachhang/username_check.php?username=" + str, true);
    xmlhttp.send();

    if (xmlhttp.responseText == "0")
        return false;
    else
        return true;
}

function password_check() {
    var pw1 = document.forms["createAccountForm"]["password"].value;
    var pw2 = document.forms["createAccountForm"]["password2"].value;
    if (pw1 != pw2) {
        document.getElementById("creat_password2-error").innerHTML = "password do not match";
        document.getElementById("creat_password2-error").style = "margin-bottom: 10px;";
        return false;
    } else {
        document.getElementById("creat_password2-error").innerHTML = "";
        document.getElementById("creat_password2-error").style = "margin-bottom: 0;";
        return true;
    }
}

function password_type() {
    var pw1 = document.forms["createAccountForm"]["password"];
    var pw2 = document.forms["createAccountForm"]["password2"];
    if (pw1.value == "") {
        pw2.disabled = true;
        pw2.value = "";
        document.getElementById("creat_password2-error").innerHTML = "";
        document.getElementById("creat_password2-error").style = "margin-bottom: 0;";
    } else {
        pw2.disabled = false;
    }
    pw1.addEventListener("keyup", function (){
        pw2.value = "";
    });
}

//Đổi thông tin
var change_info_submit = document.getElementById("change_info-submit");
if (change_info_submit) {
    change_info_submit.addEventListener("click", function(){
        var hoten = document.getElementById("hoten").value;                                                                            
        var sdt = document.getElementById("sdt").value;
        var diachi = document.getElementById("diachi").value;
        var tinhtp = document.getElementById("tinhtp").value;
        var quanhuyen = document.getElementById("quanhuyen").value;
        var xaphuongtt = document.getElementById("xaphuongtt").value;
        var info = "?hoten="+hoten+"&sdt="+sdt+"&diachi="+diachi+"&tinhtp="+tinhtp+"&quanhuyen="+quanhuyen+"&xaphuongtt="+xaphuongtt;

        var sdt_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        if (sdt != "" && sdt_regex.test(sdt) == false) {
            document.getElementById("sdt-error").innerHTML = "Invalid phone number format";
            document.getElementById("sdt-error").style = "margin-bottom: 10px;";
        } else {
            document.getElementById("sdt-error").innerHTML = "";
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText == "1") {
                    document.getElementById("change_info-error").innerHTML = "Successfully updated your profile";
                    document.getElementById("change_info-error").style = "margin-bottom: 10px;";
                } else {
                    document.getElementById("change_info-error").innerHTML = "Something wrong happened!";
                    document.getElementById("change_info-error").style = "margin-bottom: 10px;";
                }
            }
            xmlhttp.open("GET", "../khachhang/change-info.php"+info, true);
            xmlhttp.send();
        }
    });
}
//Đổi mật khẩu
var change_pw_submit = document.getElementById("change_pw-submit");
if (change_pw_submit) {
    change_pw_submit.addEventListener("click", function login(){
        var old_pw = document.getElementById("old_pw").value;
        var new_pw = document.getElementById("new_pw").value;
        var new_pw2 = document.getElementById("new_pw2").value;
        if (old_pw == "" || old_pw == null) {
            document.getElementById("old_pw-error").innerHTML = "Enter your current password";
            document.getElementById("old_pw-error").style = "margin-bottom: 10px;";
        }
        if (new_pw == "" || new_pw == null) {
            document.getElementById("new_pw-error").innerHTML = "Enter new password";
            document.getElementById("new_pw-error").style = "margin-bottom: 10px;";
        }
        if (new_pw2 == "" || new_pw2 == null) {
            document.getElementById("new_pw2-error").innerHTML = "Enter new password confirm";
            document.getElementById("new_pw2-error").style = "margin-bottom: 10px;";
        }
        if (new_pw != new_pw2) {
            document.getElementById("new_pw2-error").innerHTML = "password do not match";
            document.getElementById("new_pw2-error").style = "margin-bottom: 10px;";
        }
        if (old_pw != "" && new_pw != "" && new_pw2 != "" && new_pw == new_pw2) {
            var pw = "old_pw="+old_pw+"&new_pw="+new_pw;
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText == "1") {
                    document.getElementById("new_pw2-error").innerHTML = "Your password has been changed";
                    document.getElementById("new_pw2-error").style = "margin-bottom: 10px;";
                    setTimeout(clearPWForm, 2000);
                } else if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText == "-1"){
                    document.getElementById("old_pw-error").innerHTML = "Incorrect password!";
                    document.getElementById("old_pw-error").style = "margin-bottom: 10px;";
                } else if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText == "0") {
                    document.getElementById("new_pw2-error").innerHTML = "Something wrong happened!";
                    document.getElementById("new_pw2-error").style = "margin-bottom: 10px;";
                }
            }
            xmlhttp.open("POST", "../khachhang/change-pw.php", true);
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp.send(pw);
        }
    }, false);
}

function clearPWForm() {
    document.getElementById("old_pw-error").innerHTML = "";
    document.getElementById("new_pw-error").innerHTML = "";
    document.getElementById("new_pw2-error").innerHTML = "";
    document.getElementById("old_pw-error").style = "margin-bottom: 0;";
    document.getElementById("new_pw-error").style = "margin-bottom: 0;";
    document.getElementById("new_pw2-error").style = "margin-bottom: 0;";
    document.getElementById("old_pw").value = "";
    document.getElementById("new_pw").value = "";
    document.getElementById("new_pw2").value = "";
}

var var_old_pw = document.getElementById("old_pw");
if (var_old_pw) {
    var_old_pw.addEventListener("keyup", function (){
        document.getElementById("old_pw-error").innerHTML = "";
        document.getElementById("old_pw-error").style = "margin-bottom: 0;";
    });
}

var var_new_pw = document.getElementById("old_pw");
if (var_new_pw) {
        var_new_pw.addEventListener("keyup", function (){
        document.getElementById("new_pw-error").innerHTML = "";
        document.getElementById("new_pw-error").style = "margin-bottom: 0;";
    });
}

var var_new_pw2 = document.getElementById("old_pw");
if (var_new_pw2) {
    var_new_pw2.addEventListener("keyup", function (){
        document.getElementById("new_pw2-error").innerHTML = "";
        document.getElementById("new_pw2-error").style = "margin-bottom: 0;";
    });
}

function changepassword_type() {
    var pw1 = document.getElementById("new_pw");
    var pw2 = document.getElementById("new_pw2");
    if (pw1.value == "") {
        pw2.disabled = true;
        pw2.value = "";
    } else {
        pw2.disabled = false;
    }
    pw1.addEventListener("keyup", function (){
        pw2.value = "";
    });
}
<?php
    include ("../connect.php");
    session_start();
    if (isset($_SESSION["idnv"])) {
        header("location: index.php");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Đăng nhập</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
            <h1 class="display-4 mb-4">Đăng nhập</h1>
            <form action="login.php" method="post" class="login-form border rounded p-5 needs-validation bg-white" novalidate>
                <?php
                    if (isset($_SESSION["login_message"]) && $_SESSION["login_message"] == false) {
                        echo '
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Đăng nhập thất bại!</strong><br>Tên tài khoản hoặc mật khẩu không chính xác, bạn hãy đăng nhập lại.
                </div>
                        ';
                        unset($_SESSION["login_message"]);
                    } else if (isset($_SESSION["login_message"]) && $_SESSION["login_message"] == true) {
                        echo '
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Đăng nhập thành công!</strong>
                </div>
                        ';
                        unset($_SESSION["login_message"]);
                    }
                ?>
                <div class="form-group">
                    <label for="username">Tên tài khoản</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    <div class="invalid-feedback">
                        Vui lòng điền nhập tên đăng nhập
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <div class="invalid-feedback">
                        Hãy nhập mật khẩu
                    </div>
                </div>
                <input type="submit" name="submit" class="btn btn-primary mt-1" value="Đăng nhập">
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $login = $conn->query("SELECT * FROM nhanvien WHERE username='$username' AND password='$password'");
        if ($login->num_rows == 1) {
            $row_login = $login->fetch_assoc();
            $_SESSION["idnv"] = $row_login["idnv"];
            $_SESSION["tennv"] = $row_login["hoten"];
            $_SESSION["login_message"] = true;
            header("location: index.php");
        } else {
            $_SESSION["login_message"] = false;
            header("location: login.php");
        }
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        // Disable form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>
  </body>
</html>
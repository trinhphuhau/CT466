<?php
    require ("../connect.php");
    session_start();
    if (!isset($_SESSION["idnv"])) {
      header("location: ./login.php");
    } else {
      unset ($_SESSION["login_message"]);
      if (isset($_GET["signout"])) {
        unset ($_SESSION["idnv"]);
        $url = $_GET["redirect"];
        header("location: $url");
      }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Trang quản lý</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <header>
      <div class="container-fluid bg-primary">
        <div class="nav-info">
          <div class="text-right text-light">
            <?php echo $_SESSION["tennv"]; ?> 
            <span class="material-icons" id="signout">logout</span>
          </div>
        </div>
      </div>
    </header>
    <section>
      <div class="row mr-0">
        <!-- Menu -->
        <div class="col-2 border-right pr-0 menu">
          <ul class="nav flex-column">
              <li class="nav-item">
                  <a class="nav-link" href="../index.php"><span class="material-icons-outlined"> space_dashboard </span> Dashboard</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link active" href="./sanpham/sanpham.php"><span class="material-icons-outlined"> storefront </span> Products</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./khohang/khohang.php"><span class="material-icons-outlined"> inventory_2 </span> Kho hàng</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href=./donhang/donhang.php"><span class="material-icons-outlined"> feed </span> Orders</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./nhanvien/nhanvien.php"><span class="material-icons-outlined"> person </span> Nhân viên</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./thongke/thongke.php"><span class="material-icons-outlined"> pie_chart </span> Thống kê</a>
              </li>
          </ul>
        </div>
        <!-- Content -->
        <div class="col-10 bg-light wrapper">

        </div>
      </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $("#signout").click(function(){
          location.href = '?redirect=<?php echo $url ?>&signout';
        });
      });
    </script>
  </body>
</html>
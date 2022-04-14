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
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
    #columnchart_material::-webkit-scrollbar, #columnchart_material1::-webkit-scrollbar {
      width: 0;
    }
    
    #columnchart_material, #columnchart_material1 {
      -webkit-overflow-scrolling: touch;
    }

    label {
      font-weight: 600;
    }
    </style>
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
                <a class="nav-link active" href="index.php"><span class="material-icons-outlined"> space_dashboard </span> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sanpham/sanpham.php"><span class="material-icons-outlined"> storefront </span> Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="khohang/khohang.php"><span class="material-icons-outlined"> inventory_2 </span> Inventory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donhang/donhang.php"><span class="material-icons-outlined"> feed </span> Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="nhanvien/nhanvien.php"><span class="material-icons-outlined"> account_circle </span> Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="khachhang/khachhang.php"><span class="material-icons-outlined"> people </span> Customers</a>
            </li>
          </ul>
        </div>
        <!-- Content -->
        <?php
          $nhanvien = $conn->query("SELECT *
                                    FROM nhanvien, congviec
                                    WHERE idnv = '".$_SESSION["idnv"]."'
                                      AND congviec.macv = nhanvien.macv");
          $row_nv = $nhanvien->fetch_assoc();
        ?>
        <div class="col-10 bg-light wrapper">
          <div class="alert alert-success mt-3">
            Welcome <strong><?php echo $_SESSION["tennv"]; ?>!</strong>
          </div>
          <section style="margin: 15px">
            <div class="row">
              <div class="col-6 p-0">
                <div class="bg-white p-4 border rounded">
                  <h2 class="display-4">Your Profile</h2>
                  <div class="pt-2">
                    <form action="">
                      <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" name="" id="" class="form-control" value="<?php echo $row_nv["hoten"] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="">Job</label>
                        <input type="text" name="" id="" class="form-control" value="<?php echo $row_nv["tencv"] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="">Phone Number</label>
                        <input type="text" name="" id="" class="form-control" value="<?php echo $row_nv["sdt"] ?>">
                      </div>
                      <div class="form-group">
                        <input type="submit" class="btn btn-primary w-100" value="Update">
                      </div>
                    </form>
                  </div>
                </div>
                <div class="bg-white p-4 border rounded mt-3">
                  <h2 class="display-4">Change Password</h2>
                  <div class="pt-2">
                    <form onsubmit="return formChangePw('changepw<?php echo $row_nv['idnv'] ?>')" name="changepw<?php echo $row_nv["idnv"] ?>">
                      <div class="mb-2">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold" style="width: 162px">Username</span>
                          </div>
                          <input type="text" class="form-control" value="<?php echo $row_nv['username'] ?>" readonly>
                        </div>
                      </div>
                      <div class="mb-2">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold" style="width: 162px">Current Password</span>
                          </div>
                          <input type="password" class="form-control" name="current_pw" placeholder="Enter Current Password">
                        </div>
                      </div>
                      <div class="mb-2">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold" style="width: 162px">New Password</span>
                          </div>
                          <input type="password" class="form-control" name="pw" placeholder="Enter new password">
                        </div>
                      </div>
                      <div class="mb-2">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold" style="width: 162px">Confirm Password</span>
                          </div>
                          <input type="password" class="form-control" name="pw1" placeholder="Please confirm password">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6 pr-1">
                          <input type="reset" class="btn btn-secondary w-100" value="Reset">
                        </div>
                        <div class="col-6 pl-1">
                          <input type="submit" class="btn btn-primary w-100" value="Change">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-white p-4 border rounded">
                  <h2 class="display-4">Manager's Message</h2>
                  <?php
                    $thongbao = $conn->query("SELECT * FROM thongbaoadmin ORDER BY date DESC LIMIT 0, 5"); 
                    while($row_thongbao = $thongbao->fetch_assoc()) {
                      $nv_thongbao = $conn->query("SELECT * FROM nhanvien WHERE idnv = '".$row_thongbao["idnv"]."'");
                      $row_nvtb = $nv_thongbao->fetch_assoc();
                  ?>
                    <div class="pt-3">
                      <div class="toast" data-autohide="false">
                        <div class="toast-header">
                          <strong class="mr-auto text-primary"><?php echo $row_nvtb["hoten"] ?></strong>
                          <small class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($row_thongbao["date"])); ?></small>
                        </div>
                        <div class="toast-body">
                          <?php echo $row_thongbao["thongbao"] ?>
                        </div>
                      </div>
                    </div>
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>
          </section>
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
      
      $(document).ready(function(){
        $('.toast').toast('show');
      });
    </script>
  </body>
</html>
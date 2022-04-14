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
  // date_default_timezone_set('Asia/Ho_Chi_Minh');
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
            <li class="nav-item">
                <a class="nav-link" href="thongbao.php"><span class="material-icons-outlined"> campaign </span> Message</a>
            </li>
          </ul>
        </div>
        <!-- Content -->
        <?php
          $khachhang = $conn->query("SELECT count(idkh) AS total FROM khachhang");
          $row_khachhang = $khachhang->fetch_assoc();
          $order = $conn->query("SELECT count(madh) AS total, sum(tongtienhang) AS tongtien FROM donhang");
          $row_order = $order->fetch_assoc();
        ?>
        <div class="col-10 bg-light wrapper">
          <section style="margin: 15px">
            <div class="row card-group" id="card_today">
              <div class="col card mr-3 border rounded text-left">
                <div class="card-body">
                  <h4 class="card-title">New Customers</h4>
                  <div class="clearfix">
                    <h5 class="display-5 card-text float-left"><?php echo $row_khachhang["total"] ?></h5>
                    <span class="material-icons rounded-circle bg-danger p-3 float-right"> portrait </span>
                  </div>
                </div>
              </div>
              <div class="col card mr-3 border rounded text-left">
                <div class="card-body">
                  <h4 class="card-title">New Orders</h4>
                  <div class="clearfix">
                    <h5 class="display-5 card-text float-left"><?php echo $row_order["total"] ?></h5>
                    <span class="material-icons-outlined rounded-circle bg-primary p-3 float-right"> description </span>
                  </div>
                </div>
              </div>
              <div class="col card border rounded text-left">
                <div class="card-body">
                  <h4 class="card-title">Earning</h4>
                  <div class="clearfix">
                    <h5 class="display-5 card-text float-left"><?php echo number_format($row_order["tongtien"],0,",",".") ?>₫</h5>
                    <span class="material-icons-outlined rounded-circle bg-warning p-3 float-right"> paid </span>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section>
            <?php
              $product0 = $conn->query("SELECT count(idsp) AS total FROM sanpham WHERE tinhtrang = '0'");
              $row_product0 = $product0->fetch_assoc();
              $product1 = $conn->query("SELECT count(idsp) AS total FROM sanpham WHERE tinhtrang = '1'");
              $row_product1 = $product1->fetch_assoc();
            ?>
            <div>
              <div class="card-group">
                <div class="card">
                  <div class="card-header">
                    <i class="material-icons"> format_list_bulleted </i>
                    <span>Product Information</span>
                    </div>
                  <div class="card-body">
                    <ul class="card-text">
                      <li class="d-flex justify-content-between align-items-center">
                        Products:
                        <span class="badge badge-info badge-pill"><?php echo $row_product1["total"] ?></span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        Not confirmed yet:
                        <span class="badge badge-danger badge-pill"><?php echo $row_product0["total"] ?></span>
                      </li>
                    </ul>
                  </div>
                </div>
                <?php
                  $total_product = $conn->query("SELECT sum(solg) AS total FROM khohang");
                  $row_total_product = $total_product->fetch_assoc();
                  $stock = $conn->query("SELECT sum(sohgton) AS total FROM khohang");
                  $row_stock = $stock->fetch_assoc();
                  $oostock = $conn->query("SELECT count(F.idsp) AS total
                                          FROM (SELECT idsp, count(sohgton) as total FROM khohang WHERE sohgton = '0' GROUP BY idsp) F
                                          WHERE f.total = '3'");
                  $row_oostock = $oostock->fetch_assoc();
                ?>
                <div class="card">
                  <div class="card-header">
                    <i class="material-icons"> format_list_bulleted </i>
                    <span>Inventory Information</span>
                  </div>
                  <div class="card-body">
                    <ul class="card-text">
                      <li class="d-flex justify-content-between align-items-center">
                        Total products:
                        <span class="badge badge-info badge-pill"><?php echo $row_total_product["total"] ?></span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        In-stock:
                        <span class="badge badge-info badge-pill"><?php echo $row_stock["total"] ?></span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        Out-of-stuck:
                        <span class="badge badge-danger badge-pill"><?php echo $row_oostock["total"] ?></span>
                      </li>
                    </ul>
                  </div>
                </div>
                <?php
                  $orders = $conn->query("SELECT count(madh) AS total FROM donhang");
                  $row_orders = $orders->fetch_assoc();
                  $completed_o = $conn->query("SELECT count(madh) AS total FROM donhang WHERE matt='ht'");
                  $row_completed_o = $completed_o->fetch_assoc();
                  $cancelled_o = $conn->query("SELECT count(madh) AS total FROM donhang WHERE matt='dh'");
                  $row_cancelled_o = $cancelled_o->fetch_assoc();
                ?>
                <div class="card">
                  <div class="card-header">
                    <i class="material-icons"> format_list_bulleted </i>
                    <span>Order Information</span>
                  </div>
                  <div class="card-body">
                    <ul class="card-text">
                      <li class="d-flex justify-content-between align-items-center">
                        Total orders:
                        <span class="badge badge-info badge-pill"><?php echo $row_orders["total"] ?></span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        Processing orders:
                        <span class="badge badge-info badge-pill"><?php echo $row_orders["total"]-$row_completed_o["total"]-$row_cancelled_o["total"] ?></span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        Completed orders:
                        <span class="badge badge-info badge-pill"><?php echo $row_completed_o["total"] ?></span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        Cancelled orders:
                        <span class="badge badge-info badge-pill"><?php echo $row_cancelled_o["total"] ?></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section id="chart">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <div id="columnchart_material1"
                     class="p-4 bg-white border rounded"
                     style="width: auto; height: 525px; overflow-y: scroll; margin-top: 15px">
                </div>
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <div id="columnchart_material"
                    class="p-4 bg-white border rounded"
                    style="width: auto; height: 525px; overflow-y: scroll; margin-top: 15px">
                </div>
              </div>
            </div>
          </section>
          <section style="margin-top: 15px">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-5">
                <h4>Best Selling</h4>
                <table class="table table-hover bg-white table-borderless border rounded">
                  <thead class="thead-light">
                    <tr>
                      <th>Product</th>
                      <th>Sales</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        $bestsell = $conn->query("SELECT sp.idsp, sum(solg) AS total, ten
                                                      FROM donhangchitiet dh, sanpham sp
                                                      WHERE dh.idsp = sp.idsp
                                                      GROUP BY dh.idsp
                                                      ORDER BY total DESC
                                                      LIMIT 5");
                        while($row_bestsell = $bestsell->fetch_assoc()) {                                
                      ?>
                      <tr>
                        <td><?php echo $row_bestsell["ten"] ?></td>
                        <td><span class="badge badge-primary badge-pill"><?php echo $row_bestsell["total"] ?></span></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                </table>
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-7">
                <h4>Recent Orders</h4>
                <table class="table table-hover bg-white table-borderless border rounded">
                  <thead class="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>Total Price</th>
                      <th>Placed Time</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        $recent_orders = $conn->query("SELECT donhang.madh, tongtienhang, thoigian
                                                      FROM donhang, donhangthoigian
                                                      WHERE donhang.madh = donhangthoigian.madh AND donhangthoigian.matt = 'cxn'
                                                      ORDER BY thoigian DESC
                                                      LIMIT 5");
                        while($row_recent_orders = $recent_orders->fetch_assoc()) {
                          $date = date_create($row_recent_orders["thoigian"]);

                      ?>
                      <tr>
                        <td><span class="font-weight-bold"><?php echo $row_recent_orders["madh"] ?></span></td>
                        <td><span class="color-test text-primary font-weight-bold"><?php echo number_format($row_recent_orders["tongtienhang"],0,",",".") ?>₫</span></td>
                        <td><span><?php echo date_format($date, "H:i d/m/Y") ?></span></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                </table>
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
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      <?php
        $time_array = array();
        $time = '28';
        $end = date("Y-m-d");
        $start = ''.date("Y-m-d", strtotime('-'.$time.' days')).'';
        $date = ''.date_format(date_create($start), "d/m/Y").' vs '.date_format(date_create($end), "d/m/Y").'';;
        
        for ($i = 1; $i <= 8; $i++) {
          $time = '7';
          if ($i == 1) {
            $end = date("Y-m-d");
            $start = ''.date("Y-m-d", strtotime('-'.$time.' days')).'';
          } else {
            $start = ''.date("Y-m-d", strtotime('-'.$time*$i.' days')).'';
          }
          $week = $conn->query("SELECT COUNT(madh) AS total
                                FROM donhangthoigian
                                WHERE date(thoigian) BETWEEN '$start' AND '$end'
                                AND donhangthoigian.matt = 'cxn'");
          $row_week = $week->fetch_assoc();
          $end = ''.date("Y-m-d", strtotime('-1 days', strtotime($start))).'';
          $time_array[] = $row_week["total"];
        }
      ?>

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Week', 'Last Month', 'This Month'],
          <?php
            for($i = 3; $i >= 0; $i--) {
              $j = $i + 1;
              echo '["Week '.$j.'", '.$time_array[$i+4].', '.$time_array[$i].'], ';
            }
          ?>
        ]);
        var options = {
          chart: {
            title: 'Compare Total Orders',
            subtitle: 'This Month with Last Month'
          },
          colors: ['#6c35c7', '#355bc7']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script> 
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart1);
      
      <?php
        $order_total = 0;
        $hour_array = array();
        $end = date("Y-m-d H:i:s");
        $start = ''.date("Y-m-d H:i:s", strtotime('-1 hours')).'';
        for ($i = 0; $i <= 23; $i++) {
          $hour = '1';
          $end = ''.date("Y-m-d H:i:s", strtotime('-'.$i*$hour.' hours')).'';
          $time = $conn->query("SELECT COUNT(madh) AS total
                                FROM donhangthoigian
                                WHERE hour(thoigian) = hour('$end')
                                  AND date(thoigian) = date('$end')
                                  AND donhangthoigian.matt = 'cxn'");
          $row_time = $time->fetch_assoc();
          $order_total += $row_time["total"];
          $hour_array[] = $row_time["total"];
        }
      ?>
      
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['', <?php for($i = 23; $i >= 0; $i--) {
                    // $j = $i+1;
                    // if ($i == 0) echo '"Now", ';
                    // if ($i == 1) echo '"'.$i.' hour ago", ';
                    if ($i != 0 && $i != 1) echo '"'.$i.' hours ago", ';
                    if ($i == 1) echo '"'.$i.' hour ago", ';
                    if ($i == 0)  echo '"Now", ';
                  } ?>],
          ['Time', <?php for($i = 23; $i >= 0; $i--) { echo ''.$hour_array[$i].', ';}?>]
        ]);

        var options = {
          chart: {
            title: 'Total Orders: <?php echo ''.$order_total.'' ?>',
            subtitle: 'Last 24 hours',
          },
          colors: [<?php for($i = 0; $i < 23; $i++) echo "'#5891f0',"; echo "'#8db8ff'"; ?>],
          legend: {
            position: 'none'
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </body>
</html>
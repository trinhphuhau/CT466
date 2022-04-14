<?php
    require ("../connect.php");
    session_start();
    if (!isset($_SESSION["idnv"])) {
      header("location: ../login.php");
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
    <title>Invention</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      label {
        font-weight: 600;  
      }

      #inventory td, #newStaff td {
        vertical-align: middle;
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
                <a class="nav-link" href="../index.php"><span class="material-icons-outlined"> space_dashboard </span> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../sanpham/sanpham.php"><span class="material-icons-outlined"> storefront </span> Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../khohang/khohang.php"><span class="material-icons-outlined"> inventory_2 </span> Inventory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../donhang/donhang.php"><span class="material-icons-outlined"> feed </span> Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../nhanvien/nhanvien.php"><span class="material-icons-outlined"> account_circle </span> Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../khachhang/khachhang.php"><span class="material-icons-outlined"> people </span> Customers</a>
            </li>
          </ul>
        </div>
        <!-- Content -->
        <div class="col-10 bg-light wrapper">
          <div class="bg-white mx-2 my-4" id="stockIn">
            <div class="px-5 py-4 border rounded">
              <div>
                <h3 class="display-4 mb-3">Stock In</h3>
                <button type="button" class="close" id="closeNewStockForm">
                  <span>&times;</span>
                </button>
              </div>
              <div id="alertAddStock">
              </div>
              <div class="form-group clearfix">
                <div class="input-group float-left" style="width: calc(100% - 55px)">
                  <div class="input-group-prepend">
                    <span class="input-group-text material-icons">search</span>
                  </div>
                  <input type="text" class="form-control" onkeyup="searchProduct(this.value)" placeholder="Searching...">
                </div>
                <a href="#" class="btn btn-outline-primary material-icons-outlined float-right">add</a>
              </div>
              <div class="form-group" id="searchProduct"></div>
              <form id="addStockForm"
                    name="addStockForm"
                    class="needs-validation"
                    action="nhaphang-action.php"
                    method="get"
                    novalidate>
                <div class="row">
                  <div class="col-6 pr-2">
                    <div class="form-group">
                      <label for="number">No.</label>
                      <input type="text" name="madonnhap" class="form-control" placeholder="Number" required>
                    </div>
                  </div>
                  <div class="col-6 pl-2">
                    <div class="form-group">
                      <label for="thoigiannhap">Date <small class="text-muted">(Month/Day/Year)</small></label>
                      <input type="date" name="thoigiannhap" class="form-control" required>
                    </div>
                  </div>
                </div>
                <table class="border rounded table table-bordered table-responsive-lg" id="bangthemhang">
                  <thead class="thead-light">
                    <tr>
                      <th>Product</th>
                      <th>Small</th>
                      <th>Medium</th>
                      <th>Large</th>
                      <th style="width: 50px;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="5" class="text-center">Vui lòng tìm kiếm hoặc thêm sản phẩm mới</td>
                    </tr>
                  </tbody>
                </table>
                <div class="mb-2">
                  <input type="submit" class="btn btn-primary w-100" value="Stock In" id="nhaphang-btn">
                </div>
              </form>
            </div>
          </div>
          <div class="bg-white mx-2 my-4">
            <div class="px-5 py-4 border rounded">
              <h1 class="display-2 mb-3">Inventory</h1>
              <div class="form-group clearfix">
                <div class="input-group float-left" style="width: calc(100% - 120px)">
                  <div class="input-group-prepend">
                    <span class="input-group-text material-icons">search</span>
                  </div>
                  <input type="text" class="form-control" id="search" placeholder="What are you looking for?">
                </div>
                <button class="btn btn-info float-right" id="addStock">
                  <span class="material-icons-outlined">history</span>
                  History
                </button>
              </div>
              <table class="border rounded table table-borderless table-responsive-lg" id="inventory">
                  <thead class="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>Product</th>
                      <th>Ordered</th>
                      <th>Stock</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $khohang = $conn->query("SELECT idsp, ten FROM sanpham LIMIT 0,5");
                      while($row_khohang = $khohang->fetch_assoc()) {
                    ?>
                    <tr class="border-bottom">
                      <td><?php echo $row_khohang["idsp"]; ?></td>
                      <td class="font-weight-bold"><?php echo $row_khohang["ten"]; ?></td>
                      <?php
                        $khohang_array = array();
                        $kichthuoc = $conn->query("SELECT * FROM kichthuoc ORDER BY stt");
                        while($row_kichthuoc = $kichthuoc->fetch_assoc()) {
                          $size = $conn->query("SELECT size, solg, sohgton
                                                FROM khohang, kichthuoc
                                                WHERE khohang.masize = '".$row_kichthuoc["masize"]."'
                                                AND kichthuoc.masize = '".$row_kichthuoc["masize"]."'
                                                AND khohang.idsp = '".$row_khohang['idsp']."'
                                                ORDER BY kichthuoc.stt");
                          while($row_size = $size->fetch_assoc()) {
                            $khohang_array[] = array("".$row_size["size"]."", "".$row_size["solg"]."", "".$row_size["sohgton"]."");
                      ?>
                      <?php
                          }
                        }
                      ?>
                      <td>
                        <?php
                          for($i = 0; $i < count($khohang_array); $i++) {
                        ?>
                        <div class="mt-2 mb-2 d-flex align-items-center justify-content-between rounded p-2 mr-2 border border-info text-info">
                          <span><?php echo $khohang_array[$i][0] ?></span>
                          <span class="float-right badge badge-info badge-pill"><?php echo $khohang_array[$i][1] ?></span>
                        </div>
                        <?php
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          for($i = 0; $i < count($khohang_array); $i++) {
                        ?>
                        <div class="mt-2 mb-2 d-flex align-items-center justify-content-between rounded p-2 mr-2 border border-<?php if ($khohang_array[$i][2] == 0) echo 'danger'; else echo 'info'; ?> text-<?php if ($khohang_array[$i][2] == 0) echo 'danger'; else echo 'info'; ?>">
                          <?php echo $khohang_array[$i][0] ?>
                          <span class="badge badge-<?php if ($khohang_array[$i][2] == 0) echo 'danger'; else echo 'info'; ?> badge-pill"><?php echo $khohang_array[$i][2] ?></span>
                        </div>
                        <?php
                          }
                        ?>
                      </td>
                      <td class="text-center">
                        <a href="#" class="btn btn-success material-icons-outlined">create</a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
              </table>
              <nav aria-label="Page navigation" style="margin-top: 35px">
                <ul class="pagination justify-content-center">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $("#signout").click(function(){
          location.href = '?redirect=<?php echo $url ?>&signout';
        });

        $("#addStock").click(function(){
          $("#stockIn").toggle(500);
        });

        $("#closeNewStockForm").click(function(){
          $("#addStockForm").toggle(500);
        });
      });

      // searchProduct("");

      function searchProduct(str) {
        $.ajax({
          url: 'search-product.php',
          type: 'GET',
          dataType: 'html',
          data: {
            search: str
          },
          success: function(data) {
            $("#searchProduct").html(data);
          }
        });
      }

      var i = 0;
      var b = 0;
      function addRowTable(tt, idsp) {
        i++;
        var table = document.getElementById("bangthemhang");
        var thongtin = document.getElementById("bangthongtin");
        if (i == 1) {
          var row = table.insertRow(i);
          row.id = i;
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);
          cell1.innerHTML = thongtin.rows[tt].cells[1].innerHTML;
          cell2.insertAdjacentHTML('afterbegin', '<input type="number" name="oldproduct[S][]" class="form-control" value="0">');
          cell3.insertAdjacentHTML('afterbegin', '<input type="number" name="oldproduct[M][]" class="form-control" value="0">');
          cell4.insertAdjacentHTML('afterbegin', '<input type="number" name="oldproduct[XL][]" class="form-control" value="0">');
          cell5.insertAdjacentHTML('afterbegin', '<input type="hidden" name="oldproduct[idsp][]" value="'+idsp+'">');
          cell5.insertAdjacentHTML('afterbegin', '<a href="javascript: deleteRow('+i+')" class="btn btn-outline-secondary material-icons-outlined">remove</a>');
          document.getElementById("nhaphang-btn").style.display = "block";
        }
        if (i >= 2) {
          var row = table.insertRow(i);
          row.id = i;
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);
          cell1.innerHTML = thongtin.rows[tt].cells[1].innerHTML;
          cell2.insertAdjacentHTML('afterbegin', '<input type="number" name="oldproduct[S][]" class="form-control" value="0">');
          cell3.insertAdjacentHTML('afterbegin', '<input type="number" name="oldproduct[M][]" class="form-control" value="0">');
          cell4.insertAdjacentHTML('afterbegin', '<input type="number" name="oldproduct[XL][]" class="form-control" value="0">');
          cell5.insertAdjacentHTML('afterbegin', '<input type="hidden" name="oldproduct[idsp][]" value="'+idsp+'">');
          cell5.insertAdjacentHTML('afterbegin', '<a href="javascript: deleteRow('+i+')" class="btn btn-outline-secondary material-icons-outlined">remove</a>');
          //Trừ 2 do có dòng "Vui lòng tìm kiếm hoặc thêm sản phẩm mới" ở cuối
          for (var a = 1; a < table.rows.length-2; a++) {
            if (table.rows[a].cells[0].innerHTML == table.rows[table.rows.length-2].cells[0].innerHTML) {
              window.alert("Đã tồn tại!");
              deleteRow(i);
              break;
            }
          }
        }
      }
      
      var a = 0;
      function addNewRow() {
        var table = document.getElementById("bangthemhang");
        var thongtin = document.getElementById("bangthongtin");
        i++;
        var row = table.insertRow(i);
        row.id = i;
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        cell1.insertAdjacentHTML('afterbegin', '<input type="text" name="newproduct[ten][]" class="form-control" placeholder="Tên sản phẩm">');
        cell2.insertAdjacentHTML('afterbegin', '<input type="number" name="newproduct[S][]" class="form-control" value="0">');
        cell3.insertAdjacentHTML('afterbegin', '<input type="number" name="newproduct[M][]" class="form-control" value="0">');
        cell4.insertAdjacentHTML('afterbegin', '<input type="number" name="newproduct[XL][]" class="form-control" value="0">');
        cell5.insertAdjacentHTML('afterbegin', '<a href="javascript: deleteRow('+i+')" class="btn btn-outline-secondary material-icons-outlined">remove</a>');
        document.getElementById("nhaphang-btn").style.display = "block";
      }
    
    function deleteRow(tt) {
      document.getElementById(tt).remove();
      i--;
      if (i == 0) {
        document.getElementById("nhaphang-btn").style.display = "none";
      }
    }

    function submitNhapHang() {
      var thoigian = dateTime();
      document.getElementById('thoigian').value = thoigian;
      document.getElementById('submit-nhaphang-form').click();
    }
    </script>
  </body>
</html>
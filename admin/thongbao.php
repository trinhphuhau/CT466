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
    <script src="ckeditor/ckeditor.js"></script>
    <style>
      label {
        font-weight: 600;
      }

      #message td {
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
                <a class="nav-link" href="index.php"><span class="material-icons-outlined"> space_dashboard </span> Dashboard</a>
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
                <a class="nav-link active" href="../thongbao.php"><span class="material-icons-outlined"> campaign </span> Message</a>
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
          <div class="bg-white mx-2 my-4">
            <div class="px-5 py-4 border rounded">
              <h1 class="display-2 mb-3">Message</h1>
              <div id="order">
                <table class="border rounded table table-borderless table-responsive-lg" id="message">
                  <thead class="thead-light">
                    <th>#</th>
                    <th>Messsage</th>
                    <th>Date</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <?php
                      $thongbao = $conn->query("SELECT * FROM thongbaoadmin");
                      while($row_thongbao = $thongbao->fetch_assoc()) {
                    ?>
                    <tr class="border-bottom">
                      <td><?php echo $row_thongbao["mathongbao"] ?></td>
                      <td><?php echo $row_thongbao["thongbao"] ?></td>
                      <td><?php echo $row_thongbao["date"] ?></td>
                      <td>
                        <form action="xoathongbao.php" id="xoaThongBao<?php echo $row_thongbao["mathongbao"] ?>" name="xoaThongBao<?php echo $row_thongbao["mathongbao"] ?>">
                          <input type="hidden" name="mathongbao" value="<?php echo $row_thongbao["mathongbao"] ?>">
                          <a href="javascript: xoaThongBao(<?php echo $row_thongbao["mathongbao"] ?>)" class="material-icons-outlined btn btn-danger"> delete </a>
                        </form>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="bg-white mx-2 my-4">
            <div class="px-5 py-4 border rounded">
                <h1 class="display-4 mb-3">New Message</h1>
                <div class="col-12 p-0" id="alertNewMessage"></div>
                <form id="newMessage"
                      name="newMessage"
                      onsubmit="return formNewMessage();">
                  <textarea name="description" id="description" placeholder="Type the content here!"></textarea>
                  <script>CKEDITOR.replace('description');</script>
                  <input type="submit" class="btn btn-primary w-100 mt-3" value="Add" id="nhaphang-btn" style="display: block;">
                </form>
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
      });
      
      function xoaThongBao(id){
        document.getElementById("xoaThongBao"+id).submit();
      }

      $(document).ready(function(){
        $('.toast').toast('show');
      });

      function formNewMessage() {
        var form = document.forms.newMessage;
        var formData = new FormData(form);
        var description = 'description';
        var description_id = '#description';
        CKEDITOR.instances[description].updateElement();
        formData.append('description', $(description_id).val());

        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        formData.append('thoigian', dateTime);
        formData.append('idnv', <?php echo $_SESSION["idnv"]; ?>)

        $.ajax({
          url: 'themthongbao.php',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function(data){
            if (data == 'success') {
              location.href = 'thongbao.php';
              // $("#alertNewMessage").html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> This product has been successfully updated</div>');
            } else {
              $("#alertNewMessage").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong, can not updated this product</div>');
            }
          }
        });

        return false;
      }
    </script>
  </body>
</html>
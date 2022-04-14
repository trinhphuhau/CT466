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

    if (isset($_GET['page'])) {
      $current_page = $_GET['page'];
    } else {
      $current_page = 1;
    }

    if (isset($_GET['matt'])) {
      $matt = $_GET['matt'];
    } else {
      $matt = "";
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Orders</title>
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
      #orders td {
        vertical-align: middle;
      }

      tr:hover:nth-child(odd) {
        transition: 0.5s;
        background-color: rgb(240, 240, 240, 0.6);
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
                <a class="nav-link" href="../khohang/khohang.php"><span class="material-icons-outlined"> inventory_2 </span> Inventory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../donhang/donhang.php"><span class="material-icons-outlined"> feed </span> Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../nhanvien/nhanvien.php"><span class="material-icons-outlined"> account_circle </span> Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../khachhang/khachhang.php"><span class="material-icons-outlined"> people </span> Customers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../thongbao.php"><span class="material-icons-outlined"> campaign </span> Message</a>
            </li>
          </ul>
        </div>
        <!-- Content -->
        <div class="col-10 bg-light wrapper">
          <div class="bg-white mx-2 my-4">
            <div class="px-5 py-4 border rounded">
              <h1 class="display-2 mb-3">Orders</h1>
              <div class="form-group clearfix">
                <div class="input-group float-left" style="width: 60%">
                  <div class="input-group-prepend">
                    <span class="input-group-text material-icons">search</span>
                  </div>
                  <input type="text"
                         class="form-control"
                         id="search"
                         placeholder="What are you looking for?"
                         onkeyup="search(this.value)"
                         value="<?php if(isset($_GET["search"])) echo $_GET["search"] ?>">
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Change Status</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to change this order's status?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"
                                class="btn btn-primary"
                                id="idUpdate"
                                data-dismiss="modal"
                                onclick="#">Change</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="float-right" style="width: 38.5%">
                  <select class="form-control form-control" onchange="location = this.value;" id="">
                    <option value="donhang.php">All</option>
                    <?php
                      $tinhtrang_array = array();
                      $tinhtrang = $conn->query("SELECT * FROM donhangtinhtrang ORDER BY stt");
                      while($row_tinhtrang = $tinhtrang->fetch_assoc()) {
                        $tinhtrang_array[] = array($row_tinhtrang["matt"], $row_tinhtrang["tinhtrang"]);
                    ?>
                      <option value="?matt=<?php echo $row_tinhtrang["matt"] ?>"<?php if ($matt == $row_tinhtrang["matt"]) echo "selected"; ?>><?php echo $row_tinhtrang["tinhtrang"] ?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div id="order">

              </div>
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

      search('<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>');
      function search(str) {
        $.ajax({
          url: 'order.php',
          type: 'GET',
          dataType: 'html',
          data: {
            search: str,
            matt: '<?php echo $matt ?>',
            page: <?php echo $current_page ?>
          },
          success: function(data) {
            $("#order").html(data);
          }
        });
      }
      
      function changeStatus(id) {
        var ahref = "#"+id;
        var tr = "#tr"+id.slice(3);
        $(ahref).toggle(500);
        $(tr).toggleClass("greyColor");
      }

      function setOrder(id){
        var product = id;
        $("#idUpdate").attr("onclick", "formSubmit('"+id+"')");
      }

      function formSubmit(name) {
        var form = document.forms.namedItem(name);
        var formData = new FormData(form);
        var alert = "#alert"+name;
        var status = "#status"+name;
        var matt = form["matt"].value;
        
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        formData.append('thoigian', dateTime);

        $.ajax({
          url: 'change-status.php',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function(data){
            if (data == 'success') {
              $(alert).html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> This product has been successfully updated</div>');
              if (matt == "cxn") {
                $(status).html('<span class="badge badge-secondary">To Confirm</span>');
              } else if (matt == "clh") {
                $(status).html('<span class="badge badge-warning">To Ship</span>');
              } else if (matt == "dvc") {
                $(status).html('<span class="badge badge-primary">To Receive</span>');
              } else if (matt == "ht") {
                $(status).html('<span class="badge badge-success">Completed</span>');
              } else if (matt == "dh") {
                $(status).html('<span class="badge badge-danger">Cancelled</span>');
              }
            } else {
              $(alert).html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong, can not updated this product</div>');
            }
          }
        });

        return false;
      };
    </script>
  </body>
</html>
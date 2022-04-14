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
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Products</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="../ckeditor/ckeditor.js"></script>
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
                <a class="nav-link active" href="../sanpham/sanpham.php"><span class="material-icons-outlined"> storefront </span> Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../khohang/khohang.php"><span class="material-icons-outlined"> inventory_2 </span> Inventory</a>
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
          <div class="bg-white mx-2 my-4">
            <div class="px-5 py-4 border rounded">
              <h1 class="display-2 mb-3">Products</h1>
              <div class="form-group clearfix">
                <div class="input-group float-left" style="width: calc(100% - 155px)">
                  <div class="input-group-prepend">
                    <span class="input-group-text material-icons">search</span>
                  </div>
                  <input type="text"
                         class="form-control"
                         id="search"
                         value="<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>"
                         onkeyup="search(this.value)"
                         placeholder="What are you looking for?"
                         autocomplete="off">
                </div>
                <button class="btn btn-success float-right">
                  <span class="material-icons-outlined">add</span>
                  New Product
                </button>
              </div>
              <div id="product">
                
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

      function greyItem(id) {
        document.getElementById(id).classList.toggle("greyColor");
      };

      function preview(id) {
        var n = '#'+id;
        $(n).attr('src', URL.createObjectURL(event.target.files[0]));
      };

      search('<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>');
      function search(str) {
        $.ajax({
          url: 'product.php',
          type: 'GET',
          dataType: 'html',
          data: {
            search: str,
            page: <?php echo $current_page ?>
          },
          success: function(data) {
            $("#product").html(data);
          }
        });
      }

      // (function() {
      //   'use strict';
      //   window.addEventListener('click', function() {
      //     // Get the forms we want to add validation styles to
      //     var forms = document.getElementById('formDetail1');
      //     // Loop over them and prevent submission
      //     var validation = Array.prototype.filter.call(forms, function(form) {
      //       form.addEventListener('click', function(event) {
      //         if (form.checkValidity() === false) {
      //             event.preventDefault();
      //             event.stopPropagation();
      //         }
      //         form.classList.add('was-validated');
      //       }, false);
      //     });
      //   }, false);
      // })();

      function typeList(value, typeListID) {
        $.ajax({
          url: 'type.php',
          type: 'GET',
          dataType: 'html',
          data: {
            gender: value
          },
          success: function(data) {
            $(typeListID).html(data);
          }
        });
      };

      function formSubmit(name) {
        var form = document.forms.namedItem(name);
        var formData = new FormData(form);
        var alert = '#alert'+name;
        var stock = '#stock'+name;
        var status = '#status'+name;
        var confirm = '#confirm'+name;

        var description = 'description'+name;
        var description_id = '#description'+name;
        CKEDITOR.instances[description].updateElement();
        formData.append('description', $(description_id).val());

        var tinhtrang = $(confirm).prop('checked');
        $(confirm).change(function(){
          tinhtrang = !tinhtrang;
        });

        $.ajax({
          url: 'update.php',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function(data){
            if (data == 'success') {
              $(alert).html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> This product has been successfully updated</div>');
              if (tinhtrang == true) {
                if ($(stock).html() == 0) {
                  $(status).html('<span class="badge badge-danger">Out of Stock</span>');
                } else if ($(stock).html() > 0) {
                  $(status).html('<span class="badge badge-success">Available</span>');
                }
              } else {
                $(status).html('<span class="badge badge-secondary">Pending</span>');
              }
            } else {
              $(alert).html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong, can not updated this product</div>');
            }
          }
        });

        return false;
      };
      
      function updateProduct(id) {
        var product = id;
        $("#idUpdate").attr("onclick", "formSubmit('"+id+"')");
      }

    </script>
  </body>
</html>
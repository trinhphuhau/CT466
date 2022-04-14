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
            <li class="nav-item">
                <a class="nav-link" href="../thongbao.php"><span class="material-icons-outlined"> campaign </span> Message</a>
            </li>
          </ul>
        </div>
        <div class="col-10 bg-light wrapper">
          <!-- Add new product -->
          <div class="bg-white mx-2 my-4" id="addNewProductForm">
            <div class="px-5 py-4 border rounded">
                <div>
                  <h3 class="display-4 mb-3">Add Product</h3>
                  <button type="button" class="close" id="closeNewProductForm">
                    <span>&times;</span>
                  </button>
                </div>
                <form id="newProduct"
                      name="newProduct"
                      class="needs-validation"
                      onsubmit="return formUpload();"
                      novalidate>
                <div class="row formDetail">
                  <div class="col-12 p-0" id="alertNewProduct"></div>
                  <div class="col-4 pl-0">
                    <div class="productImg">
                      <label for="newProductImg" style="cursor: pointer;">
                          <img src="../img/cloth.png"
                              class="detail_img rounded productImg1"
                              id="newProductImgID">
                          <img src="../img/camera.png" class="rounded productCamera">
                      </label>
                      <input type="file"
                              name="hinhanh"
                              class="hide"
                              id="newProductImg"
                              oninput="preview('newProductImgID')">
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="row pb-3">
                      <div class="col-12 p-0 pr-2">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Product name" required>
                        <div class="invalid-feedback">Enter product name</div>
                      </div>
                    </div>
                    <div class="row pb-3">
                      <div class="col-9 p-0 pr-2">
                        <label for="name">Chất liệu</label>
                        <input type="text" class="form-control" name="chatlieu" placeholder="Chất liệu" required>
                        <div class="invalid-feedback">Chất liệu</div>
                      </div>
                      <div class="col-3 p-0">
                        <label for="price">Price (₫)</label>
                        <input type="text" class="form-control" name="price" placeholder="Price" required>
                        <div class="invalid-feedback">Enter price</div>
                      </div>
                    </div>
                    <div class="row pb-3">
                      <div class="col-6 p-0">
                        <label for="gender">Gender</label>
                        <br>
                        <?php
                          $gioitinh = array('Unisex', 'Nữ', 'Nam');
                          for ($i = 0; $i < 3; $i++) {
                        ?>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input  type="radio"
                                  name="gender"
                                  id="newProductGender<?php echo $i ?>"
                                  value="<?php echo $i ?>"
                                  class="custom-control-input"
                                  onClick="typeList(<?php echo $i ?>, '#newProductType')"
                                  <?php if($gioitinh[$i] == 'Unisex') echo 'checked'; ?>>
                          <label class="custom-control-label" for="newProductGender<?php echo $i ?>"><?php echo $gioitinh[$i] ?></label>
                        </div>
                        <?php
                          }
                        ?>
                      </div>
                      <div class="col-6 p-0">
                        <label for="type">Type</label>
                        <select class="custom-select" name="type" id="newProductType">
                          <option value="">Select Type</option>
                        </select>
                      </div>
                    </div>
                    <div class="row pb-3 mt-2">
                      <div class="col-12 p-0">
                        <div class="custom-control custom-switch">
                          <input type="checkbox"
                                  class="custom-control-input"
                                  name="confirm"
                                  id="confirm">
                          <label class="custom-control-label" for="confirm">Confirm</label>
                        </div>
                      </div>
                    </div>
                    <div class="row pb-3">
                      <div class="col-12 p-0">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="Type the content here!"></textarea>
                        <script>CKEDITOR.replace('description');</script>
                        <div class="invalid-feedback">Enter description</div>
                      </div>
                    </div>
                    <div class="row pb-3">
                      <div class="col-12 p-0">
                        <input type="submit" class="btn btn-primary w-100" value="Add">
                        <!-- Button trigger modal -->
                        <!-- <button type="button"
                                class="btn btn-primary btn-lg w-100"
                                data-toggle="modal" data-target="#modelUpload">
                          Upload
                        </button>
                        <div class="modal fade" id="modelUpload" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Add New Product</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to add new product?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button"
										                    data-dismiss="modal"
                                        onclick="formUpload()"
                                        class="btn btn-primary">Upload</button>
                              </div>
                            </div>
                          </div>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="modelUpdate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Update Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                  <div class="container-fluid">
                    Are you sure you want to update this product?
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button"
                          id="idUpdate"
                          data-dismiss="modal"
                          onclick="formSubmit('<?php echo $row_sanpham['idsp'] ?>')"
                          class="btn btn-primary">Update</button>
                </div>
              </div>
            </div>
          </div>
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
                <button class="btn btn-success float-right" id="addNewProduct">
                  <span class="material-icons-outlined">add</span>
                  New Product
                </button>
              </div>
              <div id="product"></div>
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

      $(document).ready(function(){
        $("#signout").click(function(){
          location.href = '?redirect=<?php echo $url ?>&signout';
        });
      });

      $(document).ready(function(){
        $("#addNewProduct").click(function(){
          $("#addNewProductForm").toggle(500);
        });

        $("#closeNewProductForm").click(function(){
          $("#addNewProductForm").toggle(500);
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
      
      typeList(0, '#newProductType');
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

      function formUpload() {
        var form = document.forms.newProduct;
        var formData = new FormData(form);
        console.log(form.length);
        for(var i = 2; i < form.length-7; i++) {
          if (form[i].value == "") {
            var heybestie = false;
          } else {
            var heybestie = true;
          }
        }
        // var heybestie = true;
        if (heybestie == true) {
          var description = 'description';
          var description_id = '#description';
          CKEDITOR.instances[description].updateElement();
          formData.append('description', $(description_id).val());

          var tinhtrang = $(confirm).prop('checked');
          $(confirm).change(function(){
            tinhtrang = !tinhtrang;
          });

          var today = new Date();
          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
          var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
          var dateTime = date+' '+time;
          formData.append('dateadded', dateTime);

          $.ajax({
            url: 'upload.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(data){
              if (data == 'success') {
                $("#alertNewProduct").html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> This product has been successfully updated</div>');
                search('<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>');
              } else {
                $("#alertNewProduct").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong, can not updated this product</div>');
              }
            }
          });
        }

        return false;
      }
      
      function updateProduct(id) {
        var product = id;
        $("#idUpdate").attr("onclick", "formSubmit('"+id+"')");
      }

    </script>
  </body>
</html>
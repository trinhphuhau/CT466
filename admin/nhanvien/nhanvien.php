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
    <title>Staff</title>
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

      #staffs td {
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
                <a class="nav-link" href="../donhang/donhang.php"><span class="material-icons-outlined"> feed </span> Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../nhanvien/nhanvien.php"><span class="material-icons-outlined"> account_circle </span> Staff</a>
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
          <!-- Add New Staff -->
          <div class="bg-white mx-2 my-4" id="addNewStaffForm">
            <div class="px-5 py-4 border rounded">
              <div>
                <h3 class="display-4 mb-3">Add New Staff</h3>
                <button type="button" class="close" id="closeNewStaffForm">
                  <span>&times;</span>
                </button>
              </div>
              <div id="alertNewStaff">
              </div>
              <form id="newStaff"
                    name="newStaff"
                    onsubmit="return formNewStaff();"
                    class="needs-validation"
                    novalidate>
                <div class="row pb-3">
                  <div class="col-6 pr-2">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Full name" required>
                    <div class="invalid-feedback">Enter full name</div>
                  </div>
                  <div class="col-6 pl-2">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="Phone number" required>
                    <div class="invalid-feedback">Enter phone number</div>
                  </div>
                </div>
                <div class="row pb-3">
                  <div class="col-6 pr-2">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <div class="invalid-feedback">Enter username</div>
                  </div>
                  <div class="col-6 pl-2">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <div class="invalid-feedback">Enter password</div>
                  </div>
                </div>
                <div class="row pb-3">
                  <div class="col-12 pb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="House number, street name,..." required>
                    <div class="invalid-feedback">Enter address</div>
                  </div>
                  <div class="col-4 pr-2">
                    <select class="custom-select" name="tinhtp" id="tinhtp" onchange="alibaba(this.value)" required>
                      <option value="">Province/City</option>
                      <?php
                        $tinhtp = $conn->query("SELECT * FROM tinhthanhpho ORDER BY name");
                        while ($row_tinhtp = $tinhtp->fetch_assoc()) { ?>
                      <option value="<?php echo $row_tinhtp["matp"] ?>"><?php echo $row_tinhtp["name"] ?></option>
                      <?php    }
                        ?>
                    </select>
                    <div class="invalid-feedback">Select province/city</div>
                  </div>
                  <div class="col-4 pr-2 pl-2">
                    <select class="custom-select" name="quanhuyen" id="quanhuyen" onchange="xaphuong(this.value)" required>
                      <option value="">District</option>
                    </select>
                    <div class="invalid-feedback">Select district</div>
                  </div>
                  <div class="col-4 pl-2">
                    <select class="custom-select" name="xaphuongtt" id="xaphuongtt" required>
                        <option value="">Commune/Ward/Townlet</option>
                    </select>
                    <div class="invalid-feedback">Select commune/ward/townlet</div>
                  </div>
                </div>
                <div class="row pb-3">
                  <div class="col-12">
                    <label for="job">Job</label>
                    <select class="custom-select" name="macv" required>
                      <option value="">Select Job</option>
                      <?php
                        $job = $conn->query("SELECT * FROM congviec");
                        while($row_job = $job->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $row_job["macv"] ?>"><?php echo $row_job["tencv"] ?></option>
                      <?php } ?>
                    </select>
                    <div class="invalid-feedback">Please select job</div>
                  </div>
                </div>
                <div class="row pb-3">
                  <div class="col-6 pr-2">
                    <input type="reset" class="btn btn-secondary w-100" value="Reset">
                  </div>
                  <div class="col-6 pl-2">
                    <input type="submit" class="btn btn-primary w-100" value="Add">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="bg-white mx-2 my-4">
            <div class="px-5 py-4 border rounded">
              <h1 class="display-2 mb-3">Staff</h1>
              <div class="form-group clearfix">
                <div id="alert-job">
                </div>
                <div class="input-group float-left" style="width: calc(100% - 130px)">
                  <div class="input-group-prepend">
                    <span class="input-group-text material-icons">search</span>
                  </div>
                  <input type="text" class="form-control" id="search" onkeyup="search(this.value)" placeholder="What are you looking for?">
                </div>
                <button class="btn btn-success float-right" id="addNewStaff">
                  <span class="material-icons-outlined">person_add_alt</span>
                  New Staff
                </button>
              </div>
              <div id="staff"></div>
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
        $("#addNewStaff").click(function(){
          $("#addNewStaffForm").toggle(500);
        });

        $("#closeNewStaffForm").click(function(){
          $("#addNewStaffForm").toggle(500);
        });
      });

      function alibaba(matp) {
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

      search('<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>');
      function search(str) {
        $.ajax({
          url: 'staff.php',
          type: 'GET',
          dataType: 'html',
          data: {
            search: str,
            page: <?php echo $current_page ?>
          },
          success: function(data) {
            $("#staff").html(data);
          }
        });
      }

      function formNewStaff() {
        var form = document.forms.newStaff;
        var formData = new FormData(form);

        for(var i = 0; i < 5; i++) {
          if (form[i].value == "") {
            var heybestie = false;
          } else {
            var heybestie = true;
          }
        }

        if (heybestie == true) {
          $.ajax({
            url: 'themnhanvien.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(data){
              if (data == 'success') {
                $("#alertNewStaff").html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> Account successfully created</div>');
                setTimeout(function(){ $("#addNewStaffForm").load('add-staff.php'); }, 5000);
                search('<?php if (isset($_GET["search"])) echo $_GET["search"]; ?>');
              } else {
                $("#alertNewStaff").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong</div>');
              }
            }
          });
        }
        
        return false;
      }

      function formChangePw(name) {
        var id = name.slice(8);
        var alert = "#alert-changepw"+id;
        var form = document.forms.namedItem(name);
        var formData = new FormData(form);
        formData.append('idnv', id);
        $.ajax({
          url: 'change-pw.php',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function(data){
            if (data == 'success') {
              $(alert).html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> Password has changed successfully</div>');
            } else {
              $(alert).html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong, please try again later</div>');
            }
          }
        });
        
        return false;
      }

      function formChangeJob(idnv, macv) {
        var job = "#job"+idnv;
        $.ajax({
          url: 'change-job.php',
          type: 'GET',
          dataType: 'html',
          data: {
            idnv: idnv,
            macv: macv
          },
          success: function(data) {
            if (data == 'success') {
              $("#alert-job").html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Successfully!</strong> Password has changed successfully</div>');
              search('<?php if (isset($_GET["search"])) echo $_GET["search"]; else  ?>');
            } else {
              $("#alert-job").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Failed!</strong> Something went wrong, please try again later</div>');
            }
          }
        });
      };

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

      function edit(id) {
        var ahref = "#"+id;
        var tr = "#tr"+id.slice(11);
        $(ahref).toggle(500);
        $(tr).toggleClass("greyColor");
      }
    </script>
  </body>
</html>
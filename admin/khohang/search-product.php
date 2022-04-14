<?php
  require ("../connect.php");
  $search = $_GET['search'];
  // $current_page   = $_GET['page'];
    if ($search != "") {
      echo '
        <table class="border rounded table table-borderless table-responsive-lg" id="bangthongtin">
        <thead class="thead-light">
          <tr>
              <th>#</th>
              <th>Product</th>
              <th></th>
          </tr>
        </thead>
        ';
      $count = $conn->query("SELECT COUNT(idsp) AS total FROM sanpham WHERE ten LIKE '%".$search."%'");
      $row_cnt = $count->fetch_assoc();
      if ($row_cnt['total'] > 0) {
        $tt = 0;
        $i  = 0;
        $result = $conn->query("SELECT * FROM sanpham
                                WHERE ten LIKE '%".$search."%'");
        while ($row = $result->fetch_assoc()) {
          $tt = $tt + 1;
          $i++;
          $giaban = (int)$row['giaban'];
          echo '
          <tr class="border-bottom">
            <td>'.$tt.'</td>
            <td class="font-weight-bold">'.$row["ten"].'</td>
            <td>
              <a href="javascript: addRowTable('.$tt.', '.$row["idsp"].')" class="btn btn-outline-secondary material-icons-outlined">add</a>
            </td>
          </tr>
          ';
        }
        echo "</table><br>";
      } else {
        echo '
          <tr>
            <td colspan="6" class="text-center">
              Không có sản phẩm này trong kho hàng
            </td>
          </tr>
          </table><br>
        ';
      }
    } else {
    }
  $conn->close();
?>
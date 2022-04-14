<?php
	require ("../connect.php");
	$search = $_GET["search"];
	$current_page = $_GET["page"];
?>
<table class="border rounded table table-bordered table-borderless table-responsive-lg" id="customers">
  <thead class="thead-light">
    <tr>
      <th>#</th>
      <th>Full Name</th>
      <th>Phone Number</th>
      <th>Username</th>
      <th class="text-center">Change Password</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $count = $conn->query("SELECT count(idkh) AS total FROM khachhang
                             WHERE hoten LIKE '%".$search."%'");
      $row_cnt = $count->fetch_assoc();

      if ($row_cnt["total"] > 0) {
        $limit = 5;
        $total_records = $row_cnt['total'];
        $total_pages = ceil($total_records / $limit);
        if ($current_page > $total_pages) $current_page = $total_pages;
        $start = ($current_page - 1) * $limit;
        if ($start < 0) $start = 0;

        $stt = $start;
        $khachhang = $conn->query("SELECT * FROM khachhang WHERE hoten LIKE '%".$search."%' LIMIT $start, $limit");
        while($row_khachhang = $khachhang->fetch_assoc()) {
          $stt++;
          $diachi = $conn->query("SELECT tp.name tpn, qh.name qhn, tt.name ttn
                    FROM khachhang kh, tinhthanhpho tp, quanhuyen qh, xaphuongthitran tt
                    WHERE kh.matp = tp.matp
                      AND kh.maqh = qh.maqh
                      AND kh.xaid = tt.xaid
                      AND kh.idkh = '".$row_khachhang["idkh"]."'");
          if ($diachi->num_rows > 0) {
            $row_diachi = $diachi->fetch_assoc();
            $diachikh = ' '.$row_khachhang["diachi"].', '.$row_diachi["ttn"].', '.$row_diachi["qhn"].', '.$row_diachi["tpn"].' ';
          } else {
            $diachikh = '';
          }
    ?>
    <tr class="border-bottom">
      <td class="font-weight-bold"><?php echo $stt; ?></td>
      <td><?php echo $row_khachhang["hoten"]; ?></td>
      <td><?php echo $row_khachhang["sdt"]; ?></td>
      <td class="font-weight-bold"><?php echo $row_khachhang["username"]; ?></td>
      <td class="text-center" style="width: 157px">
        <a href="javascript: showChange('customerChange<?php echo $row_khachhang["idkh"] ?>')" class="btn btn-success material-icons-outlined">create</a>
      </td>
      <td class="text-center" style="width: 130px">
        <a href="javascript: showDetail('customerDetail<?php echo $row_khachhang["idkh"] ?>')" class="btn btn-primary material-icons-outlined">visibility</a>
      </td>
    </tr>
    <tr class="border-bottom hide" id="customerDetail<?php echo $row_khachhang["idkh"] ?>">
      <td colspan="6" class="p-4 bg-light">
        <div class="rounded mb-4">
          <div>
            <h4 class="display-5">Customer Information</h4>
            <div class="border rounded px-3 pt-3 bg-white" style="line-height: 1">
              <p><span class="font-weight-bold">Full Name:</span> <?php echo $row_khachhang["hoten"] ?></p>
              <p><span class="font-weight-bold">Phone Number:</span> <?php echo $row_khachhang["sdt"] ?></p>
              <p><span class="font-weight-bold">Username:</span> <?php echo $row_khachhang["username"] ?></p>
              <p><span class="font-weight-bold">Address:</span> <?php echo $diachikh ?></p>
            </div>
          </div>
        </div>
        <div>
          <h4 class="display-5">Recent Orders</h4>
          <table class="border rounded table table-bordered table-borderless table-responsive-lg">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Total</th>
                <th>Placed Time</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $donhang = $conn->query(" SELECT *, dh.madh AS madonhang, dh.matt AS matinhtrang, tp.name AS thanhpho, qh.name AS quanhuyen, tt.name AS thitran
                                          FROM donhang dh, donhangtinhtrang dhtt, donhangthoigian dhtg, tinhthanhpho tp, quanhuyen qh, xaphuongthitran tt
                                          WHERE dh.matt = dhtt.matt
                                            AND dh.matp = tp.matp
                                            AND dh.maqh = qh.maqh
                                            AND dh.xaid = tt.xaid
                                            AND dhtg.matt = 'cxn'
                                            AND dh.madh = dhtg.madh
                                            AND dh.idkh = '".$row_khachhang["idkh"]."'
                                          GROUP BY dh.madh
                                          ORDER BY dh.madh DESC
                                          LIMIT 0, 5
                                          ");
                if ($donhang->num_rows > 0) {
                  while($row_donhang = $donhang->fetch_assoc()) {
                    $date = date_create($row_donhang["thoigian"]);
              ?>
              <tr id="tr<?php echo $row_donhang["madonhang"] ?>" class="border-bottom bg-white">
                <td class="font-weight-bold"><?php echo $row_donhang["madonhang"]; ?></td>
                <td><?php echo $row_donhang["hoten"]; ?></td>
                <td><?php echo $row_donhang["sdt"]; ?></td>
                <td>
                  <span class="color-test text-primary font-weight-bold"><?php echo number_format($row_donhang["tongtienhang"]+$row_donhang["phivanchuyen"],0,",",".") ?>₫</span>
                </td>
                <td><?php echo date_format($date, "H:i d/m/Y") ?></td>
                <td class="text-center" style="width: 100px" id="status<?php echo $row_donhang["madonhang"] ?>">
                  <span class="badge badge-<?php
                    if ($row_donhang["matinhtrang"] == "dh") {
                      echo "danger";
                    } else if ($row_donhang["matinhtrang"] == "cxn") {
                      echo "secondary";
                    } else if ($row_donhang["matinhtrang"] == "clh") {
                      echo "warning";
                    } else if ($row_donhang["matinhtrang"] == "dvc") {
                      echo "primary";
                    } else echo "success";
                  ?>"><?php echo $row_donhang["tinhtrang"]; ?></span>
                </td>
              </tr>
              <?php }
              } else { ?>
              <tr class="bg-white">
                <td colspan="6" class="text-center">This customer has not ordered anything yet</td>
              </tr>
              <?php
              } ?>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
    <tr class="border-bottom hide" id="customerChange<?php echo $row_khachhang["idkh"] ?>">
      <td colspan="6" class="p-4 bg-light">
        <div class="border rounded p-3 bg-white">
          <h4 class="display-5">Change Password</h4>
          <div id="alert-changepw<?php echo $row_khachhang["idkh"] ?>"></div>
          <form onsubmit="return formChangePw('changepw<?php echo $row_khachhang['idkh'] ?>')" name="changepw<?php echo $row_khachhang["idkh"] ?>">
            <div class="mb-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text font-weight-bold" style="width: 162px">Username</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $row_khachhang['username'] ?>" readonly>
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
      </td>
    </tr>
    <?php
      }
    ?>
  </tbody>
</table>
<nav aria-label="Page navigation" style="margin-top: 35px">
	<ul class="pagination justify-content-center">
		<li class="page-item <?php if ($current_page == 1) echo 'disabled'; ?>">
			<a class="page-link" href="?search=<?php echo $search ?>&page=<?php echo $current_page-1 ?>" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
				<span class="sr-only">Previous</span>
			</a>
		</li>
		<?php
			$page = 0;
			for($i = 0; $i < $total_pages; $i++) {
				$page++;
		?>
		<li class="page-item <?php if($page == $current_page) echo 'active'; ?>">
			<a class="page-link" href="?search=<?php echo $search ?>&page=<?php echo $page ?>"><?php echo $page ?></a>
		</li>
		<?php } ?>
		<li class="page-item <?php if ($current_page == $total_pages) echo 'disabled'; ?>">
			<a class="page-link" href="?search=<?php echo $search ?>&page=<?php echo $current_page+1 ?>" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
				<span class="sr-only">Next</span>
			</a>
		</li>
	</ul>
</nav>
<?php
			} else {
	?>
	<tr>
		<td colspan="7" class="text-center">Sorry, we don't have the customer that you were looking for</td>
	</tr>
	<?php
	}
	?>
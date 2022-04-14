<?php
	require ("../connect.php");
	$search = $_GET["search"];
	$current_page = $_GET["page"];
?>

<table class="border rounded table table-borderless table-responsive-lg" id="inventory">
  <thead class="thead-light">
    <tr>
      <th>ID</th>
      <th>Product</th>
      <th>Ordered</th>
      <th>Stock</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $count = $conn->query("SELECT count(idsp) AS total FROM sanpham
                             WHERE ten LIKE '%".$search."%'");
      $row_cnt = $count->fetch_assoc();

      if ($row_cnt["total"] > 0) {
        $limit = 5;
        $total_records = $row_cnt['total'];
        $total_pages = ceil($total_records / $limit);
        if ($current_page > $total_pages) $current_page = $total_pages;
        $start = ($current_page - 1) * $limit;
        if ($start < 0) $start = 0;

        $stt = $start;
        $khohang = $conn->query("SELECT idsp, ten FROM sanpham WHERE ten LIKE '%".$search."%' LIMIT $start, $limit");
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
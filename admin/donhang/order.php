<?php
	require ("../connect.php");
	$search = $_GET["search"];
	$current_page = $_GET["page"];
	$matinhtrang = $_GET["matt"];
	$tinhtrang_array = array();
	$tinhtrang = $conn->query("SELECT * FROM donhangtinhtrang ORDER BY stt");
	while($row_tinhtrang = $tinhtrang->fetch_assoc()) {
		$tinhtrang_array[] = array($row_tinhtrang["matt"], $row_tinhtrang["tinhtrang"]);
	}
?>
<table class="border rounded table table-bordered table-borderless table-responsive-lg" id="orders">
	<thead class="thead-light">
		<tr>
			<th>ID</th>
			<th>Full Name</th>
			<th>Phone Number</th>
			<th>Total</th>
			<th>Placed Time</th>
			<th class="text-center">Status</th>
			<th class="text-center">Change Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$count = $conn->query("SELECT COUNT(madh) AS total FROM donhang
														 WHERE madh LIKE '%".$search."%'");
			$row_cnt = $count->fetch_assoc();
			if ($row_cnt["total"] > 0) {
				$limit = 5;
				$total_records = $row_cnt['total'];
				$total_pages = ceil($total_records / $limit);
				if ($current_page > $total_pages) $current_page = $total_pages;
				$start = ($current_page - 1) * $limit;
				if ($start < 0) $start = 0;
				$donhang = $conn->query(" SELECT *, dh.madh AS madonhang, dh.matt AS matinhtrang, tp.name AS thanhpho, qh.name AS quanhuyen, tt.name AS thitran
																	FROM donhang dh, donhangtinhtrang dhtt, donhangthoigian dhtg, tinhthanhpho tp, quanhuyen qh, xaphuongthitran tt
																	WHERE dh.matt = dhtt.matt
																		AND dh.matp = tp.matp
																		AND dh.maqh = qh.maqh
																		AND dh.xaid = tt.xaid
																		AND dhtg.matt = 'cxn'
																		AND dh.madh = dhtg.madh
																		AND dh.matt LIKE '%".$matinhtrang."%'
																		AND dh.madh LIKE '%".$search."%'
																	GROUP BY dh.madh
																	ORDER BY dh.madh DESC
																	LIMIT $start, $limit
																	");
				while($row_donhang = $donhang->fetch_assoc()) {
					$date = date_create($row_donhang["thoigian"]);
		?>
		<tr id="tr<?php echo $row_donhang["madonhang"] ?>" class="border-bottom">
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
			<td class="text-center" style="width: 135px">
				<a href="javascript: changeStatus('trr<?php echo $row_donhang["madonhang"] ?>');" class="btn text-primary material-icons-outlined" style="font-size: 15px">create</a>
			</td>
		</tr>
		<tr id="trr<?php echo $row_donhang["madonhang"] ?>" class="border-bottom hide">
			<td colspan="7" class="p-4">
				<div class="border rounded p-3 bg-light">
					<div class="clearfix">
						<h4 class="display-5 float-left">Change Status</h4>
						<button class="btn btn-primary material-icons-outlined float-right"
										data-toggle="collapse"
										data-target="#collapse<?php echo $row_donhang["madh"] ?>"
										aria-expanded="false"> visibility </button>
					</div>
					<div id="alert<?php echo $row_donhang["madonhang"] ?>"></div>
					<form onsubmit="return false" name="<?php echo $row_donhang["madonhang"] ?>" id="<?php echo $row_donhang["madonhang"] ?>">
						<div class="mb-2">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text font-weight-bold">Order ID</span>
								</div>
								<input type="text"
											class="form-control" name="madh"
											value="<?php echo $row_donhang["madonhang"] ?>"
											readonly>
							</div>
						</div>
						<div class="mb-2">
							<select name="matt" class="form-control form-control">
									<?php
										for ($i = 0; $i < count($tinhtrang_array); $i++) {
									?>
									<option value="<?php echo $tinhtrang_array[$i][0]; ?>" <?php if($tinhtrang_array[$i][0] == $row_donhang["matinhtrang"]) echo "selected"; ?>><?php echo $tinhtrang_array[$i][1]; ?></option>
									<?php } ?>
								</select>
						</div>
						<div class="pb-0">
							<input type="button"
										class="btn btn-primary w-100"
										value="Change"
										onclick="setOrder('<?php echo $row_donhang['madonhang'] ?>')"
										data-toggle="modal" data-target="#modelId">
						</div>
					</form>
				</div>
				<div>
					<div class="border rounded bg-light p-4 mt-4 collapse" id="collapse<?php echo $row_donhang["madh"] ?>">
						<div>
							<h4 class="display-5 clearfix">Delivery Information <span class="float-right text-danger" style="font-size: 25px"><?php echo $row_donhang["tinhtrang"] ?></span></h4>
							<div class="border rounded px-3 pt-3 bg-white" style="line-height: 1">
								<p><span class="font-weight-bold">Full Name:</span> <?php echo $row_donhang["hoten"] ?></p>
								<p><span class="font-weight-bold">Phone Number:</span> <?php echo $row_donhang["sdt"] ?></p>
								<p><span class="font-weight-bold">Address:</span> <?php echo $row_donhang["diachi"] ?>, <?php echo $row_donhang["thitran"] ?>, <?php echo $row_donhang["quanhuyen"] ?>, <?php echo $row_donhang["thanhpho"] ?></p>
								<hr>
								<?php
									for ($i = 0; $i < count($tinhtrang_array); $i++) {
										$thoigian = $conn->query("SELECT thoigian FROM donhangthoigian WHERE madh = '".$row_donhang["madonhang"]."' AND matt = '".$tinhtrang_array[$i][0]."'");
										if ($thoigian->num_rows > 0) {
											$row_thoigian = $thoigian->fetch_assoc();
											$date = date_create($row_thoigian["thoigian"]);
										?>
										<p><span class="font-weight-bold"><?php if($tinhtrang_array[$i][0] == "cxn") echo "Placed"; else echo $tinhtrang_array[$i][1]; ?> Time:</span> <?php echo date_format($date, "H:i d/m/Y") ?></p>
										<?php
										}
									}
								?>
							</div>
						</div>
						<div class="pt-3">
							<h4 class="display-5">Order Details</h4>
							<div class="border rounded px-3 pt-3 bg-white" style="line-height: 1">
							<?php
								$dhct = $conn->query("SELECT * FROM donhangchitiet dhct, sanpham sp, donhang dh
																			WHERE dhct.madh = dh.madh
																			AND dhct.idsp = sp.idsp
																			AND dh.madh = '".$row_donhang["madonhang"]."'");
								while($row_dhct = $dhct->fetch_assoc()) {
									$tongtienhang = $row_dhct["tongtienhang"];
									$phivanchuyen = $row_dhct["phivanchuyen"];
							?>
							<div class="clearfix pb-3">
								<div class="d-flex float-left" style="gap: 10px">
									<img src="<?php echo $row_dhct["hinhanh"] ?>" class="rounded" style="width: 100px; height: 100px; object-fit:cover">
									<div style="line-height: 0.8">
										<p class="font-weight-bold"><?php echo $row_dhct["ten"] ?> (x<?php echo $row_dhct["solg"] ?>)</p>
										<p><span class="font-weight-bold">Size:</span> <?php echo $row_dhct["masize"] ?></p>
										<p class="mb-0"><span class="font-weight-bold">Price:</span> <?php echo number_format($row_dhct["giaban"],0,",",".") ?>₫</p>
									</div>
								</div>
								<div class="float-right pt-2" style="line-height: 0.8">
									<span class="color-test text-info font-weight-bold"><?php echo number_format($row_dhct["giaban"]*$row_dhct["solg"],0,",",".") ?>₫</span>
								</div>
							</div>
							<?php
								}
							?>
							</div>
						</div>
						<div class="pt-3" style="line-height: 1">
							<h4 class="display-5">Order Summary</h4>
							<div class="border rounded px-3 pt-3 bg-white clearfix">
								<p>Merchandise Subtotal: <span class="float-right"><?php echo number_format($tongtienhang,0,",",".") ?>₫</span></p>
								<p class="mb-0">Shipping Fee: <span class="float-right"><?php echo number_format($phivanchuyen,0,",",".") ?>₫</span></p>
								<hr>
								<h3 class="my-3">Total: <span class="float-right"><?php echo number_format($tongtienhang+$phivanchuyen,0,",",".") ?>₫</span></h3>
							</div>
						</div>
					</div>
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
		<td colspan="7" class="text-center">Sorry, we don't have the order that you were looking for</td>
	</tr>
	<?php
	}
	?>
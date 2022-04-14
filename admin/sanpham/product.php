<?php
	require ("../connect.php");
	$search = $_GET["search"];
	$current_page = $_GET["page"];
?>
  <!-- Title -->
	<div class="container-fluid border rounded">
		<div class="row font-weight-bold border-bottom p-3">
			<div class="col-auto p-0" style="width: 70px"></div>
			<div class="col">Product</div>
			<div class="col">Type</div>
			<div class="col">Gender</div>
			<div class="col">Price (₫)</div>
			<div class="col">Stock</div>
			<div class="col">Sales</div>
			<div class="col">Status</div>
			<div class="col-auto p-0" style="width: 5%"></div>
		</div>
		<?php
			$count = $conn->query("SELECT COUNT(idsp) AS total FROM sanpham
														WHERE ten LIKE '%".$search."%'");
			$row_cnt = $count->fetch_assoc();
			if ($row_cnt["total"] > 0) {
				$limit = 5;
				$total_records = $row_cnt['total'];
				$total_pages = ceil($total_records / $limit);
				if ($current_page > $total_pages) $current_page = $total_pages;
				$start = ($current_page - 1) * $limit;
				if ($start < 0) $start = 0;

				$gioitinh = $conn->query("SELECT * FROM gioitinh");
				$gioitinh_array = array();
				while($row_gioitinh = $gioitinh->fetch_assoc()) {
					$gioitinh_array[] = array($row_gioitinh["gender"], $row_gioitinh["gioitinh"]);
				}
				$sanpham = $conn->query("SELECT *, sanpham.gioitinh AS gioitinhne
																FROM sanpham, loai
																WHERE sanpham.maloai = loai.maloai
																	AND ten LIKE '%".$search."%'
																ORDER BY idsp DESC LIMIT $start, $limit");
				while($row_sanpham = $sanpham->fetch_assoc()) {
					// Tính stock
					$outofstock = 0;
					$total_stock = 0;
					$stock_array = array();
					$total_sale = 0;
					$sale_array = array();
					$kichthuoc = $conn->query("SELECT * FROM kichthuoc ORDER BY stt");
					while($row_kichthuoc = $kichthuoc->fetch_assoc()) {
						$stock = $conn->query("SELECT size, sohgton
																	FROM khohang, kichthuoc
																	WHERE khohang.masize = '".$row_kichthuoc["masize"]."'
																	AND kichthuoc.masize = '".$row_kichthuoc["masize"]."'
																	AND khohang.idsp = '".$row_sanpham['idsp']."'
																	ORDER BY kichthuoc.stt
																");
						$stock_number = 0;
						if ($stock->num_rows > 0) {
							$row_stock = $stock->fetch_assoc();
							$stock_number = $row_stock["sohgton"];
							$total_stock += $row_stock["sohgton"];
						}
						if ($stock_number == 0) { $outofstock++; }
						$stock_array[] = array($row_kichthuoc["size"], $stock_number);

						// Tính sale 
						$sale = $conn->query("SELECT size, solg
																	FROM donhangchitiet, kichthuoc
																	WHERE kichthuoc.masize = '".$row_kichthuoc["masize"]."'
																	AND donhangchitiet.masize = '".$row_kichthuoc["masize"]."'
																	AND donhangchitiet.idsp = '".$row_sanpham['idsp']."'
																	ORDER BY kichthuoc.stt
																");
						$sale_number = 0;
						if ($sale->num_rows > 0) {
							$row_sale = $sale->fetch_assoc();
							$sale_number = $row_sale["solg"];
							$total_sale += $row_sale["solg"];
						}
						$sale_array[] = array($row_kichthuoc["size"], $sale_number);
			}
		?>
		<!-- Item -->
		<div class="row p-3 border-bottom item" id="item<?php echo $row_sanpham["idsp"] ?>">
			<!-- Hình ảnh -->
			<div class="col-auto p-0"><img src="../<?php echo $row_sanpham["hinhanh"] ?>" class="product-img"></div>
			<!-- Tên -->
			<div class="col font-weight-bold" style="width: 250px"><?php echo $row_sanpham["ten"] ?></div>
			<!-- Loại -->
			<div class="col"><?php echo $row_sanpham["tenloai"] ?></div>
			<div class="col">
			<?php
				if ($row_sanpham["gioitinhne"] == 0) echo 'Unisex';
				else if ($row_sanpham["gioitinhne"] == 1) echo 'Female';
				else echo 'Male';
			?>
			</div>
			<!-- Giá bán -->
			<div class="col">
				<span class="color-test text-primary font-weight-bold"><?php echo number_format($row_sanpham["giaban"],0,",",".") ?>₫</span>
			</div>
			<!-- Tồn kho -->
			<div class="col">
				<span style="position: relative;" class="color-test text-<?php if ($total_stock == 0) echo 'danger'; else echo 'info'; ?> font-weight-bold">
					<span id="stock<?php echo $row_sanpham["idsp"] ?>">
						<?php
							echo $total_stock;
							if ($outofstock > 0) {
						?>
					</span>
					<span class="badge badge-danger badge-pill" style="position: absolute; right: -13px; top: -4px; z-index: 99"><?php echo $outofstock ?></span>
					<?php    
						}
					?>
				</span>
			</div>
			<!-- Bán -->
			<div class="col">
				<span class="color-test text-success font-weight-bold"><?php echo $total_sale ?></span>
			</div>
			<!-- Trạng thái -->
			<div class="col" id="status<?php echo $row_sanpham["idsp"] ?>">
			<?php
				if ($row_sanpham["tinhtrang"] == 1 && $total_stock > 0)
					echo '<span class="badge badge-success">Available</span>';
				else if ($row_sanpham["tinhtrang"] == 1 && $total_stock == 0)
					echo '<span class="badge badge-danger">Out of Stock</span>';
				else echo '<span class="badge badge-secondary">Pending</span>';
			?>
			</div>
			<div class="col-auto p-0" style="width: 5%">
				<a href="#formDetail<?php echo $row_sanpham["idsp"] ?>"
						class="badge badge-primary badge-pill material-icons-outlined"
						data-toggle="collapse"
						onclick="greyItem('item<?php echo $row_sanpham['idsp'] ?>')">
					more_horiz 
				</a>
			</div>
		</div>
		<!-- Chi tiết -->
		<form class="collapse"
					id="formDetail<?php echo $row_sanpham["idsp"] ?>"
					name="<?php echo $row_sanpham["idsp"] ?>"
					onsubmit="return formSubmit(<?php echo $row_sanpham['idsp'] ?>);"
					novalidate>
			<div class="row p-3 border-bottom formDetail" data-parent="#product">
				<input type="hidden" name="idsp" value="<?php echo $row_sanpham["idsp"] ?>">
				<div class="col-12 p-0" id="alert<?php echo $row_sanpham["idsp"] ?>"></div>
				<div class="col-4 pl-0">
					<div class="productImg">
						<label for="hinhanh<?php echo $row_sanpham['idsp'] ?>" style="cursor: pointer;">
								<img src="../<?php echo $row_sanpham["hinhanh"] ?>"
											class="detail_img rounded productImg1"
											id="live_preview<?php echo $row_sanpham["idsp"] ?>"
											alt="<?php echo $row_sanpham['ten'] ?>">
								<img src="../img/camera.png" class="rounded productCamera">
						</label>
						<input type="file"
										name="hinhanh"
										class="hide"
										id="hinhanh<?php echo $row_sanpham['idsp'] ?>"
										oninput="preview('live_preview<?php echo $row_sanpham['idsp'] ?>')">
					</div>
				</div>
				<div class="col-8">
					<div class="row pb-3">
						<div class="col-12 p-0 pr-2">
							<label for="name">Product Name</label>
							<input type="text"
										 class="form-control"
										 name="name"
										 value="<?php echo $row_sanpham["ten"] ?>"
										 placeholder="Product name"
										 required>
							<div class="invalid-feedback">Please enter product name here</div>
						</div>
					</div>
					<div class="row pb-3">
						<div class="col-9 p-0 pr-2">
							<label for="name">Chất liệu</label>
							<input type="text"
										 class="form-control"
										 name="chatlieu"
										 value="<?php echo $row_sanpham["chatlieu"] ?>"
										 placeholder="Chất liệu"
										 required>
						</div>
						<div class="col-3 p-0">
							<label for="price">Price (₫)</label>
							<input type="text"
										 class="form-control"
										 name="price"
										 value="<?php echo $row_sanpham["giaban"] ?>"
										 placeholder="Price"
										 required>
						</div>
					</div>
					<div class="row pb-3">
						<div class="col-6 p-0">
							<label for="gender<?php echo $row_sanpham["idsp"] ?>">Gender</label>
							<br>
							<?php
								for ($i = 0; $i < count($gioitinh_array); $i++) {
							?>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio"
												name="gender<?php echo $row_sanpham["idsp"] ?>"
												id="gender<?php echo $gioitinh_array[$i][0] ?><?php echo $row_sanpham["idsp"] ?>"
												value="<?php echo $gioitinh_array[$i][1] ?>"
												class="custom-control-input"
												onClick="typeList(<?php echo $gioitinh_array[$i][1] ?>, '#type<?php echo $row_sanpham["idsp"] ?>')" 
												<?php if($gioitinh_array[$i][1] == $row_sanpham["gioitinhne"]) echo 'checked' ?>
												required>
								<label class="custom-control-label" for="gender<?php echo $gioitinh_array[$i][0] ?><?php echo $row_sanpham["idsp"] ?>"><?php echo $gioitinh_array[$i][0] ?></label>
							</div>
							<?php
								}
							?>
						</div>
						<div class="col-6 p-0">
							<label for="type">Type</label>
							<select class="custom-select" name="type" id="type<?php echo $row_sanpham["idsp"] ?>">
								<?php
									$type = $conn->query("SELECT * FROM loai WHERE gioitinh = '0' OR gioitinh = '".$row_sanpham["gioitinhne"]."'");
									while($row_type = $type->fetch_assoc()) {
								?>
								<option value="<?php echo $row_type["maloai"] ?>" <?php if ($row_type["maloai"] == $row_sanpham["maloai"]) echo 'selected' ?>><?php echo $row_type["tenloai"] ?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<div class="row pb-3">
						<div class="col-6 p-0">
							<label>In Stock</label>
							<div class="d-flex">
								<?php
									for($i = 0; $i < count($stock_array); $i++) {
								?>
								<span class="border border-<?php if ($stock_array[$i][1] == 0) echo 'danger'; else echo 'info'; ?> text-<?php if ($stock_array[$i][1] == 0) echo 'danger'; else echo 'info'; ?> rounded p-2 mr-2">
									<?php echo $stock_array[$i][0] ?>
									<span class="badge badge-<?php if ($stock_array[$i][1] == 0) echo 'danger'; else echo 'info'; ?> badge-pill"><?php echo $stock_array[$i][1] ?></span>
								</span>
								<?php
									}
								?>
							</div>
						</div>
						<div class="col-6 p-0">
							<label for="">Sales</label>
							<div class="d-flex">
								<?php
									for($i = 0; $i < count($stock_array); $i++) {
								?>
								<span class="border border-success text-success rounded p-2 mr-2">
								<?php echo $sale_array[$i][0] ?>
									<span class="badge badge-success badge-pill"><?php echo $sale_array[$i][1] ?></span>
								</span>
								<?php
									}
								?>
							</div>
						</div>
					</div>
					<div class="row pb-3 mt-2">
						<div class="col-6 p-0">
							<label for="">Date Added:</label>
							<span class="text-secondary"><?php echo $row_sanpham["dateadded"] ?></span>
						</div>
						<div class="col-6 p-0">
							<div class="custom-control custom-switch">
								<input type="checkbox"
												class="custom-control-input"
												name="confirm"
												id="confirm<?php echo $row_sanpham["idsp"] ?>"
												<?php if ($row_sanpham["tinhtrang"] == 1) echo "checked" ?>>
								<label class="custom-control-label" for="confirm<?php echo $row_sanpham["idsp"] ?>">Confirm</label>
							</div>
						</div>
					</div>
					<div class="row pb-3">
						<div class="col-12 p-0">
							<label for="description">Description</label>
							<textarea
								name="description<?php echo $row_sanpham["idsp"] ?>"
								id="description<?php echo $row_sanpham["idsp"] ?>"><?php echo $row_sanpham["mota"] ?></textarea>
							<script>CKEDITOR.replace('description<?php echo $row_sanpham["idsp"] ?>');</script>
						</div>
					</div>
					<div class="row pb-3">
						<div class="col-12 p-0">
							<!-- <input type="submit"> -->
							<!-- Button trigger modal -->
							<button type="button"
											class="btn btn-primary btn-lg w-100"
											onClick = "updateProduct('<?php echo $row_sanpham["idsp"]; ?>')"
											data-toggle="modal" data-target="#modelUpdate">
								Update
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
  <?php } ?>
	</div>
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
	<div class="row p-3 border-bottom item">
		<div class="col text-center">
			Sorry, we don't have the product that you were looking for
		</div>
	</div>
	<?php
	}
	?>
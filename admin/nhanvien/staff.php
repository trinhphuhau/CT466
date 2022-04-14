<?php
	require ("../connect.php");
	$search = $_GET["search"];
	$current_page = $_GET["page"];
	$job_array = array();
	$job = $conn->query("SELECT * FROM congviec");
	while($row_job = $job->fetch_assoc()) {
		$job_array[] = array($row_job["macv"], $row_job["tencv"]);
	}
?>
<table class="border rounded table table-bordered table-borderless table-responsive-lg" id="staffs">
	<thead class="thead-light">
		<tr>
			<th>#</th>
			<th>Full Name</th>
			<th>Phone Number</th>
			<th>Address</th>
			<th>Username</th>
			<th>Job</th>
			<th class="text-center">Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$count = $conn->query("SELECT count(idnv) AS total FROM nhanvien
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
				$nhanvien = $conn->query("SELECT *
																	FROM nhanvien nv, congviec cv
																	WHERE nv.macv = cv.macv
																		AND nv.hoten LIKE '%".$search."%'
																	LIMIT $start, $limit");
				while($row_nhanvien = $nhanvien->fetch_assoc()) {
					$stt++;
					$diachi = $conn->query("SELECT tp.name tpn, qh.name qhn, tt.name ttn
																	FROM nhanvien nv, tinhthanhpho tp, quanhuyen qh, xaphuongthitran tt
																	WHERE nv.matp = tp.matp
																		AND nv.maqh = qh.maqh
																		AND nv.xaid = tt.xaid
																		AND nv.idnv = '".$row_nhanvien["idnv"]."'");
					$row_diachi = $diachi->fetch_assoc();
					$diachinv = ' '.$row_nhanvien["diachi"].', '.$row_diachi["ttn"].', '.$row_diachi["qhn"].', '.$row_diachi["tpn"].' ';
		?>
		<tr class="border-bottom" id="tr<?php echo $row_nhanvien["idnv"] ?>">
			<td class="font-weight-bold"><?php echo $stt; ?></td>
			<td><?php echo $row_nhanvien["hoten"]; ?></td>
			<td><?php echo $row_nhanvien["sdt"]; ?></td>
			<td><?php echo $diachinv ?></td>
			<td class="font-weight-bold"><?php echo $row_nhanvien["username"]; ?></td>
			<td id="job<?php echo $row_nhanvien["idnv"] ?>">
				<div class="dropdown">
					<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $row_nhanvien["tencv"]; ?>
					</button>
					<form name="changejob<?php echo $row_nhanvien["idnv"] ?>">
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor: pointer">
							<?php
							for($i = 0; $i < count($job_array); $i++) {
							?>
								<li onclick="formChangeJob('<?php echo $row_nhanvien['idnv']; ?>', '<?php echo $job_array[$i][0] ?>')" class="dropdown-item<?php if ($job_array[$i][0] == $row_nhanvien["macv"]) echo ' active'; ?>"><?php echo $job_array[$i][1] ?></li>
							<?php } ?>
						</ul>
					</form>
				</div>
			</td>
			<td class="text-center">
				<a href="javascript: edit('staffChange<?php echo $row_nhanvien["idnv"] ?>');" class="btn btn-primary material-icons-outlined">create</a>
			</td>
		</tr>
		<tr class="border-bottom hide" id="staffChange<?php echo $row_nhanvien["idnv"] ?>">
			<td colspan="7" class="p-4">
				<!-- Đổi mật khẩu -->
				<div class="border rounded p-3 bg-light">
					<h4 class="display-5">Change Password</h4>
					<div id="alert-changepw<?php echo $row_nhanvien["idnv"] ?>"></div>
					<form onsubmit="return formChangePw('changepw<?php echo $row_nhanvien['idnv'] ?>')" name="changepw<?php echo $row_nhanvien["idnv"] ?>">
						<div class="mb-2">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text font-weight-bold" style="width: 162px">Username</span>
								</div>
								<input type="text" class="form-control" value="<?php echo $row_nhanvien['username'] ?>" readonly>
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
		<td colspan="7" class="text-center">Sorry, we don't have the staff that you were looking for</td>
	</tr>
	<?php
	}
	?>
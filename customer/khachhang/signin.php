<?php
	session_start();
	require ("../connect.php");
	$username = $_POST['username'];
	$redirect = $_POST['redirect'];
	$password = md5($_POST['password']);
	$sql = "SELECT idkh FROM khachhang WHERE username='$username' AND password='$password'";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$_SESSION['idkh'] = $row['idkh'];
		echo '<div class="overlay">
				<div class="response">
					<div style="text-align: center; padding: 20px;">
						<a href="../'.$redirect.'" class="material-icons close-btn" style="top: 0;">clear</a>
						<p style="font-size: 25px; margin-bottom: 25px; font-weight: 600;">Đăng nhập thành công</p>
						<img src="../img\check-circle.gif" alt="">
					</div>
				</div>
			</div>';
	} else {
		echo "0";
	}
	$conn->close();
?>
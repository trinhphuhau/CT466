<?php
	session_start();
	if(isset($_SESSION['idkh'])) {
        unset($_SESSION['idkh']);
		if(isset($_GET['redirect'])) {
			$url = $_GET['redirect'];
        	header("location: $url");
		}
		else header("location: ../index.php");
	} else header("location: ../index.php");
?>
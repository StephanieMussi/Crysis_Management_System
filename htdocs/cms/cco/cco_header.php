<html>
<head>
	<title>Unknown Crysis</title>
	<link rel="stylesheet" href="cco_style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<?php
		session_start();
		if($_SESSION['username'] == NULL || $_SESSION['type'] != "cco"){
			header("Location: ../public/public_main.php");
		}
	?>
</head>
</html>
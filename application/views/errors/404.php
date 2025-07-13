<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>

	<style type="text/css">
		body {
			background-color: #f8f9fc;
			font: 14px/20px "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			color: #5a5c69;
			margin: 0;
			padding: 0;
		}
		a {
			color: #4e73df;
			text-decoration: none;
			font-weight: 600;
		}
		.container-wrapper {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			text-align: center;
			padding: 20px;
			box-sizing: border-box;
		}
		.error-img {
			max-height: 100px;
			margin-bottom: 1rem;
		}
		h3 {
			font-size: 24px;
			color: #858796;
		}
		.lead {
			font-size: 18px;
			color: #5a5c69;
			margin-bottom: 1rem;
		}
	</style>
</head>
<body>

<div class="container-wrapper">
	<div>
		<img src="<?= base_url('assets/'); ?>img/error.svg" alt="404 Error" class="error-img">
		<h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
		<p class="lead text-gray-800 mx-auto">404 Page Not Found</p>
		<a href="<?= base_url('dashboard'); ?>">&larr; Back to Dashboard</a>
	</div>
</div>

</body>
</html>

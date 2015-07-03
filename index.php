<?php require 'config.php' ?>

<!DOCTYPE html>
<html>
	<title><?php echo TITLE ?></title>	
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ripples.min.css">
		<link rel="stylesheet" href="css/material-wfont.min.css">
		<link rel="stylesheet" href="css/taiga.css">

		<style type="text/css">
			.navbar-inverse {
				background-color: <?php echo HEADER_COLOR; ?>;
			}
		</style>
	</head>

	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">
				<?php echo TITLE ?>
			  </a>
			</div>
		  </div>
		</div>
		
		<div class="container page-contents">
			
		</div>
		
		<footer class="footer">
			<div class="container text-muted">
				some stuff goes here
			</div>
		</footer>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="js/ripples.min.js"></script>
		<script src="js/material.min.js"></script>
		<script src="js/taiga.js"></script>
	</body>
</html>

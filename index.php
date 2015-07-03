<?php require 'config.php' ?>

<!DOCTYPE html>
<html>
	<title><?php echo TITLE ?></title>	
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.css">
		<link rel="stylesheet" href="css/taiga.css">

		<style type="text/css">
			.navbar-inverse.navbar {
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
			<?php
				$files = scandir(ANIME_ROOT);
				foreach($files as $file) {
					if(strlen(str_replace('.', '', $file)) == 0)
						continue;

					$info = get_anime_info($file);
					if($info !== null) {
						echo '<div class="anime-box">';
						echo('<div class="anime-play-button"><a href="javascript:void(0)" class="btn btn-material-deep-orange-500 btn-fab btn-raised mdi-av-play-arrow"></a></div>');

						$anime = $info[0];

						$genres = $anime['genres'];
						$genres_str = '';
						foreach($genres as $genre)
							$genres_str .= $genre['name'] . ', ';
						$genres_str = substr($genres_str, 0, strlen($genres_str) - 2);

						echo '<div class="anime-image"><img src="' . $anime['cover_image'] . '"></div>';
						echo '<div class="anime-info">';
						echo '<div class="anime-name">' . $anime['title'] . '</div>';

						echo('</div></div>');
					}
				}

				function get_anime_info($anime_name) {
					if(USE_CACHE && has_cache_for($anime_name))
						$contents = file_get_contents(get_cache_file($anime_name));
					else {
						$api = 'http://hummingbird.me/api/v1/search/anime/?query=' . urlencode($anime_name);
						$contents = file_get_contents($api);
						file_put_contents(get_cache_file($anime_name), $contents);
					}
					
					return json_decode($contents, true);
				}

				function get_cache_file($anime_name) {
					return CACHE_ROOT . "/$anime_name.json";
				}

				function has_cache_for($anime_name) {
					$file = get_cache_file($anime_name);
					return file_exists($file) && filemtime($file) - time() < CACHE_REFRESH_TIME;
				}
			?>
		</div>
		
		<footer class="footer">
			<div class="container text-muted">
				some stuff goes here
			</div>
		</footer>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js"></script>
		<script src="js/taiga.js"></script>
	</body>
</html>

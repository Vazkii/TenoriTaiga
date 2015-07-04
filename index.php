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
			<div id="search-bar-container">
				<input id="search-bar" type="text"></input>
				<div class="search-icon">&#128270</div>
			</div>
		  </div>
		</div>
		
		<div class="container page-contents">
			<?php
				$files = scandir(ANIME_ROOT);
				foreach($files as $file) {
					if(strlen(str_replace('.', '', $file)) == 0)
						continue;

					$path = ANIME_ROOT . '/' . $file;
					$use_id = false;
					$id = '';
					if(file_exists($path . '/id')) {
						$use_id = true;
						$id = file_get_contents($path . '/id');
						$info = get_anime_info($file, true, $id);
					} else $info = get_anime_info($file, false);
					if($info !== null) {
						$anime = $use_id ? $info : $info[0];

						$cover_image = $anime['cover_image'];
						$title = $anime['title'];
						$age_rating = $anime['age_rating'];
						$status = $anime['status'];
						$episodes = $anime['episode_count'];
						$ep_length = $anime['episode_length'];
						$full_length = $episodes * $ep_length;
						$hb_id = $anime['id'];
						$mal_id = $anime['mal_id'];
						$genres = $anime['genres'];
						$rating = round($anime['community_rating'], 2);

						$hours = (int) ($full_length / 60);
						$mins = $full_length % 60;
						$mins_str = "$mins";
						if(strlen($mins_str) < 2)
							$mins_str = "0$mins_str";

						$genres_str = '';
						foreach($genres as $genre)
							$genres_str .= $genre['name'] . ', ';
						$genres_str = substr($genres_str, 0, strlen($genres_str) - 2);

						$episodes_dld = sizeof(scandir($path)) - ($use_id ? 3 : 2);
						$title_lc = strtolower($title);

						echo "<div class='anime-box' data-anime-name='$title_lc'>";
						echo("<div class='anime-play-button'><a href='javascript:void(0)' class='btn btn-material-" . BUTTON_COLOR . " btn-fab btn-raised mdi-av-play-arrow'></a></div>");
						echo "<div class='anime-image'><img src='$cover_image'></div>";
						echo "<div class='anime-info'>";
						echo "<div class='anime-name'>$title</div>";
						echo "<a href='https://hummingbird.me/anime/$hb_id'><img src='https://hummingbird.me/favicon.ico'></img></a> <a href='http://myanimelist.net/anime/$mal_id'><img src='http://myanimelist.net/favicon.ico'></img></a> $rating&#9733<br><br>$genres_str<br><br>$episodes_dld/$episodes EPs (${hours}h:${mins_str}m)<br>$age_rating / $status";

						echo('</div></div>');
					}
				}

				function get_anime_info($anime_name, $use_id, $id='') {
					if(USE_CACHE && has_cache_for($anime_name))
						$contents = file_get_contents(get_cache_file($anime_name));
					else {
						$api = 'http://hummingbird.me/api/v1/' . ($use_id ? "/anime/$id"  : ('search/anime/?query=' . urlencode($anime_name)));
						$contents = file_get_contents($api);
						if(USE_CACHE)
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
				Tenori Taiga, copyright lololololololol. [<a href="https://github.com/Vazkii/TenoriTaiga">Source Code</a>]
				<!-- Do not remove the previous line -->
			</div>
		</footer>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js"></script>
		<script src="js/taiga.js"></script>
	</body>
</html>

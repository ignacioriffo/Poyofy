<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

$playlists = $user->getPlaylists();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Playlist</title>
</head>
<body>
	<h1>Playlists</h1>
	<l4>Playlists de  <?php echo $user->getNombre(); ?>! </l4>

	<li class="volver">
		<a href="index.php">Volver</a>
	</li>
	<br><br>
	<?php

		echo "<form action='playlistsongs.php' method='post'>";
		foreach($playlists as $playlist){
			$playlistname = $playlist->getNombre();
			$playlistid = $playlist->getId();
			echo "<button type='submit' name='playlist' value='" . $playlistid . "'>" . $playlistname . "</button>";
		}
		echo "</form>";
	
	?>

</body>
</html>
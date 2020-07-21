<?php
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}
include_once 'user.php';
$user = new User();
$user->setUser($_SESSION['user']);
$user->isArtista($user->getId());

if($user->getIsArtista()){
	$user->setBiografia($user->getId());
}
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
		$user->setPlaylistsSeguidas($user->getId());
		$playlists = $user->getPlaylists();
		foreach($playlists as $playlist){
			$playlistname = $playlist->getNombre();
			echo "<li class='playlist'><a href='playlistsongs.php'>" . $playlistname . "</a></li>";
		}
	
	?>

</body>
</html>
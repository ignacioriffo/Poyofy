<?php
include_once "user.php";
include_once "playlist.php";
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

if(isset($_POST['playlist'])){
    $playlistid = $_POST['playlist'];
}

$playlist = new Playlist();
$playlist->setPlaylist($playlistid);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    <h1>Playlists</h1>
	<l4><?php echo $user->getNombre(); ?>! </l4>
    <li class="volver">
		<a href="homeplaylist.php">Volver</a>
	</li>
    <l4>Proximamente <?php echo $playlist->getNombre(); ?>! </l4>
</body>
</html>
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

$playlist = new Playlist();
if(isset($_POST['playlist'])){
    $playlistid = $_POST['playlist'];
    $playlist->setPlaylist($playlistid);
    $playlist->setSeguidores();
    $user->setCurrPlaylist($playlist);
}else{
    $playlist = $user->getCurrPlaylist();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    <h1><?php echo $playlist->getNombre(); ?></h1>
    <input type="hidden" name="playlist2" value=$playlist />
    <p4 class="seguidores"><a href="playlistseguidores.php">Seguidores</a></p4>
    <p4>: <?php echo $playlist->getNseguidores();?></p4>
    <li class="volver">
		<a href="homeplaylist.php">Volver</a>
	</li>
</body>
</html>
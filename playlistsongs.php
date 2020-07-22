<?php
include_once "user.php";
include_once "playlist.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

$playlist = new Playlist();
if(isset($_POST['playlist'])){
    $playlistid = $_POST['playlist'];
    $playlist->setPlaylist($playlistid);
    $playlist->setSeguidores();
    $user->setCurrPlaylist($playlist);

    $_SESSION['user'] = $user;
}else{
    $playlist = $user->getCurrPlaylist();
}

$canciones = $playlist->getCanciones();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    <h1><?php echo $playlist->getNombre(); ?></h1>
    <p1><?php echo $playlist->getDescripcion() . "<br>"; ?></h1>
    <p1>Creada por: <?php echo $playlist->getCreador() . "<br>"; ?></h1>
    <p4 class="seguidores"><a href="playlistseguidores.php">Seguidores</a></p4>
    <p4>: <?php echo $playlist->getNseguidores();?></p4>
    <li class="volver">
		<a href="homeplaylist.php">Volver</a>
	</li>
    <br><br>
    <p4 class="canciones"><a href="homecancion.php"><?php
    foreach ($canciones as $cancion){
        echo $cancion->getNombre() . "<br>";
    }
    ?></a></p4>
</body>
</html>
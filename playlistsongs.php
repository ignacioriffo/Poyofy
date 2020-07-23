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
    <p1>Por <?php echo $playlist->getCreador() . "<br>"; ?></h1>
    <p4 class="seguidores"><a href="playlistseguidores.php">Seguidores</a></p4>
    <p4>: <?php echo $playlist->getNseguidores() . "<br>";?></p4>
    <p1><?php echo $playlist->getDescripcion() . "<br><br>"; ?></h1>
    <li class="volver">
		<a href="homeplaylist.php">Volver</a>
	</li>
    <br><br>
    <?php
    echo "<form action='homecancion.php' method='post'>";
		foreach($canciones as $cancion){
            echo "<button type='submit' name='cancion' value='" . $cancion->getId() . "'>" . $cancion->getNombre() . "</button>";
            echo "<br>";
		}
    echo "</form>";
    ?>

</body>
</html>
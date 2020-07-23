<?php
include_once "user.php";
include_once "cancion.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

$cancion = new Cancion();
if(isset($_POST['cancion'])){
    $cancionid = $_POST['cancion'];
    $cancion->setCancion($cancionid);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $cancion->getNombre(); ?></h1>
    <p1><?php echo $cancion->getCreador() . "<br>"; ?></h1>
    <p1><?php 
        if(!is_null($cancion->getIdAlbum())){
            echo $cancion->getAlbum() . "<br>";
        }
    ?></h1>
    <p1><?php echo $cancion->getGenero() . "<br>"; ?></h1>
    <p1><?php echo $cancion->getDuracion() . "<br>"; ?></h1>
    <p1><?php echo $cancion->getFecha() . "<br>"; ?></h1>

    <li class="volver">
            <a href="playlistsongs.php">Volver</a>
    </li>
        
</body>
</html>
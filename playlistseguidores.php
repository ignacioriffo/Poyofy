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
$playlist = $user->getCurrPlaylist();

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
    <li class="volver">
            <a href="playlistsongs.php">Volver</a>
    </li>
    
</body>
</html>
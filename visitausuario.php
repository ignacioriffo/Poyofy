<?php
include_once "user.php";
include_once "playlist.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

$uservisita = new User();
if(isset($_POST['seguidor'])){
    $username = $_POST['seguidor'];
    $uservisita->setUserId($username);
    $uservisita->isArtista($uservisita->getId());
    if($uservisita->getIsArtista()){
        $uservisita->setBiografia($uservisita->getId());
    }
    $uservisita->setPlaylistsSeguidas($uservisita->getId());
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
    <l4><?php echo $uservisita->getNombre(); ?> </l4>
</body>
</html>
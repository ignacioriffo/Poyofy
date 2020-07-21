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
    <title>Document</title>
</head>
<body>
    <l4>Proximamente <?php echo $user->getNombre(); ?>! </l4>
</body>
</html>
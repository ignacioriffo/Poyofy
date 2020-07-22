<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user']

?>
<!DOCTYPE html>
<html>
<head>
	<title>Bienvenido</title>
</head>
<body>
	<h1>Home</h1>
	<li class="cerrar-sesion">
		<a href="logout.php">Cerrar sesión</a>
	</li>
	<l4>Bienvenido <?php echo $user->getNombre(); ?>! </l4>
	<br>
	<l4><?php
		if($user->getIsArtista()){
			echo $user->getBiografia();
		}
		?>
	</l4>
	<br>
	<li class="ver playlist">
		<a href="homeplaylist.php">Ver playlists</a>
	</li>
</body>
</html>
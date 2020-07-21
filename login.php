<!doctype html>
<?php
	include_once 'conexion2.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Poyofy</title>
</head>
<body>
	<h3>Poyofy</h3>
	<form action="" method="POST">
		<?php
			if(isset($errorLogin)){
				echo $errorLogin;
			}
		?>

		<h2>Iniciar sesión</h2><br>
		<label for="username">Nombre de usuario:</label>
		<input type="text" name="username" id="username">
		<label for="password">Contraseña:</label>
		<input type="password" name="password" id="password">
		<p class="center"><input type="submit" value="Iniciar Sesión"></p>
	</form>

	<?php
		$db = new DB();
		$db->connect();
	?>

</body>
</html>
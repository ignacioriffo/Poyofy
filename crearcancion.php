<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['cancion']) && isset($_POST['genero']) && isset($_POST['duracion']) && isset($_POST['fecha'])){
	$cancionForm = $_POST['cancion'];
    $generoForm = $_POST['genero'];
    $duracionForm = $_POST['duracion'];
    $fechaForm = $_POST['fecha'];

    $cancioncreada = "Cancion creada correctamente!";
    $user->crearCancion($cancionForm, $generoForm, $duracionForm, $fechaForm);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
  <nav class="navbar navbar-light bg-light justify-content-between">
  <a class="nav-link" href="home.php"><?php echo $user->getNombre(); ?></a>
  <a class="nav-link" href="homecanciones.php">Canciones</a>
	<a class="nav-link" href="homeplaylist.php">Playlist</a>
	<a class="nav-link" href="logout.php">Cerrar sesión</a>
  <form class="form-inline" action='busqueda.php' method='post'>
    <input class="form-control mr-sm-2" type="search" placeholder="Ingrese busqueda" aria-label="Search"  name='busqueda'>
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
  </form>
  </nav>
    <div class="container">

    <h1>Nueva canción</h1>

    <form action="" method="POST">
	<div class="form-group">
		<label for="exampleInputEmail1">Nombre Canción</label>
		<input type="text" class="form-control" name="cancion" id="cancion" aria-describedby="emailHelp" placeholder="Ingrese Nombre">
	</div>
    <div class="form-group">
		<label for="exampleInputEmail1">Genero</label>
		<input type="text" class="form-control" name="genero" id="genero" aria-describedby="emailHelp" placeholder="Ingrese Genero">
	</div>
    <div class="form-group">
		<label for="exampleInputEmail1">Duración</label>
		<input type="text" class="form-control" name="duracion" id="duracion" aria-describedby="emailHelp" placeholder="00:02:46">
	</div>
    <div class="form-group">
		<label for="exampleInputEmail1">Fecha</label>
		<input type="text" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelp" placeholder="2018-05-23">
	</div>
	    <button type="submit" class="btn btn-primary">Crear</button>
	</form>
  
    <?php
    echo "<form action='cancionesartista.php'>";
    echo "<button type='submit' class='btn btn-link' name='volver'>Volver</button>";
    echo "<br>";
    echo "</form>";

		if(isset($cancioncreada)){
            echo $cancioncreada;
		}
	?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
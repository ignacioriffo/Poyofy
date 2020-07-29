<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['cancion'])){
    $user->editarNombreCancion($_POST['cancion'], $_POST['editar']);
}

if(isset($_POST['genero'])){
    $user->editarGeneroCancion($_POST['genero'], $_POST['editar']);
}

if(isset($_POST['duracion'])){
    $user->editarDuracionCancion($_POST['duracion'], $_POST['editar']);
}


if(isset($_POST['fecha'])){
    $user->editarFechaCancion($_POST['fecha'], $_POST['editar']);
}

if(isset($_POST['editar'])){
    $cancion = new Cancion();
    $cancion->setCancion($_POST['editar']);
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

    <h1>Editar canción</h1>

    <form action="" method="POST">
	<div class="form-group">
		<label for="exampleInputEmail1">Nombre Canción</label>
        <br>
        <p6><?php echo $cancion->getNombre(); ?></p6>
		<input type="text" class="form-control" name="cancion" id="cancion" aria-describedby="emailHelp" placeholder="Ingrese Nombre">
        <?php echo '<input type="hidden" name="editar" value="' . $cancion->getId() . '">'; ?>
	</div>
    <button type="submit" class="btn btn-primary">Enviar</button>
	</form>
    <br>

    <form action="" method="POST">
    <div class="form-group">
		<label for="exampleInputEmail1">Genero</label>
        <br>
        <p6><?php echo $cancion->getGenero(); ?></p6>
		<input type="text" class="form-control" name="genero" id="genero" aria-describedby="emailHelp" placeholder="Ingrese Genero">
        <?php echo '<input type="hidden" name="editar" value="' . $cancion->getId() . '">'; ?>
	</div>
    <button type="submit" class="btn btn-primary">Enviar</button>
	</form>
    <br>

    <form action="" method="POST">
    <div class="form-group">
		<label for="exampleInputEmail1">Duración</label>
        <br>
        <p6><?php echo $cancion->getDuracion(); ?></p6>
		<input type="text" class="form-control" name="duracion" id="duracion" aria-describedby="emailHelp" placeholder="00:02:46">
        <?php echo '<input type="hidden" name="editar" value="' . $cancion->getId() . '">'; ?>
	</div>
    <button type="submit" class="btn btn-primary">Enviar</button>
	</form>
    <br>

    <form action="" method="POST">
    <div class="form-group">
		<label for="exampleInputEmail1">Fecha</label>
        <br>
        <p6><?php echo $cancion->getFecha(); ?></p6>
		<input type="text" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelp" placeholder="2018-05-23">
        <?php echo '<input type="hidden" name="editar" value="' . $cancion->getId() . '">'; ?>
	</div>
	    <button type="submit" class="btn btn-primary">Enviar</button>
	</form>
    <br>
  
    <?php
    echo "<form action='cancionesartista.php'>";
    echo "<button type='submit' class='btn btn-link' name='volver'>Volver</button>";
    echo "<br>";
    echo "</form>";

/*
		if(isset($cancioncreada)){
            echo $cancioncreada;
        }*/
        
	?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
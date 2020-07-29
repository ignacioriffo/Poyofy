<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Bienvenido!</title>
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
	<h3>Bienvenido a Poyofy!</h3>
	<p6><?php echo $user->getSeguidores() . " Seguidores"?></p6>
	<h6><?php
  
    echo "<form action='editarperfil.php'>";
    echo "<button type='submit' class='btn btn-link' name='editarperfil'>Editar perfil</button>";
    echo "<br>";
    echo "</form>";
    
    echo "<form action='userseguidos.php'>";
    echo "<button type='submit' class='btn btn-link' name='seguidos'>Seguidos</button>";
    echo "<br>";
    echo "</form>";

    if(!$user->getIsArtista()){
      echo "<form action='playlistcreadas.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='playlist'>Playlist Creadas</button>";
      echo "<br>";
      echo "</form>";
    }

    if($user->getIsArtista()){
      echo "<form action='cancionesartista.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='cancionesartista'>Canciones</button>";
      echo "<br>";
      echo "</form>";

      echo "<form action='albumesartista.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='albumesartista'>Albumes</button>";
      echo "<br>";
      echo "</form>";
    }
    
		?>
    
	</h6>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
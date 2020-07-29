<?php
include_once "user.php";
include_once "album.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

$album = new Album();
if(isset($_POST['album'])){
    $albumid = $_POST['album'];
    $album->setAlbum($albumid);
}
/*
if(isset($_POST['busqueda'])){
  $cancionbuscada = $_POST['busqueda'];
  $listabusqueda = $user->searchSongs($cancionbuscada);
  $cancionesbuscadas = $listabusqueda[0];
}

if(isset($_POST['añadirCancion'])){
  $cancionañadida = $_POST['añadirCancion'];
  $playlist->añadirCancion($cancionañadida);
}*/

if(isset($_POST['borrar'])){
  $cancionid = $_POST['borrar'];
  $album->borrarCancion($cancionid);
}

$canciones = $album->getCanciones();
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
    <h3><?php echo $album->getNombre(); ?></h3>
    <p6>Creado por  <?php echo $album->getCreador() . "<br>"; ?></p6>

    <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Artista</th>
      <th scope="col">Duración</th>
      <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
      $nsong = 1;
      foreach($canciones as $cancion){
        echo "<tr>";
        echo "<th scope='row'>" . $nsong . "</th>";
        echo "<td>" . $cancion->getNombre() . "</td>";
        echo "<td>" . $cancion->getCreador() . "</td>";
        echo "<td>" . $cancion->getDuracion() . "</td>";
        echo "<form action='albumsongs.php'  method='post'>";
        echo '<td><button type="sumbit" name="borrar" value="' . $cancion->getId() . '" class="btn btn-light">Borrar</button></td>';
        echo '<input type="hidden" name="album" value="' . $albumid . '">';
        echo "</form>";
        echo "</tr>";
        $nsong++;
      }
    ?>
    </tbody>
    </table>
    <?php
      echo "<form action='albumesartista.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='borraralbum' value='" . $album->getId() . "'>Borrar Album</button>";
      echo "<br>";
    ?>
    </div>

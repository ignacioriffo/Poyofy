<?php
include_once "user.php";
include_once "album.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['albumeditado'])){
  $user->editarNombreAlbum($_POST['albumeditado'], $_POST['album']);
}

if(isset($_POST['genero'])){
  $user->editarGeneroAlbum($_POST['genero'], $_POST['album']);
}

if(isset($_POST['fecha'])){
  $user->editarFechaAlbum($_POST['fecha'], $_POST['album']);
}

$album = new Album();
if(isset($_POST['album'])){
    $albumid = $_POST['album'];
    $album->setAlbum($albumid);
}

if(isset($_POST['busqueda'])){
  $cancionbuscada = $_POST['busqueda'];
  $cancionesbuscadas = $user->searchSongsArtista($cancionbuscada, $user->getId());
}

if(isset($_POST['añadirCancion'])){
  $cancionañadida = $_POST['añadirCancion'];
  $album->añadirCancion($cancionañadida);
}

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
    <p6><?php echo $album->getGenero() . "<br>"; ?></p6>
    <p6><?php echo $album->getFecha() . "<br>"; ?></p6>

    <?php
    echo "<form action='' method='post'>";
    echo "<button type='submit' class='btn btn-link' name='editar'>Editar</button>";
    echo '<input type="hidden" name="album" value="' . $albumid . '">';
    echo "</form>";

    if(isset($_POST['editar'])){
      echo "<br>";
      echo'<form action="" method="POST">';
      echo'<div class="form-group">';
      echo'<label for="exampleInputEmail1">Nombre Album</label>';
      echo'<br>';
      echo'<input type="text" class="form-control" name="albumeditado" id="albumeditado" aria-describedby="emailHelp" placeholder="Ingrese Nombre">';
      echo '<input type="hidden" name="album" value="' . $albumid . '">';
      echo '<input type="hidden" name="editar">';
      echo'</div>';
      echo'<button type="submit" class="btn btn-primary">Enviar</button>';
      echo'</form>';
      echo'<br>';

      echo'<form action="" method="POST">';
      echo'<div class="form-group">';
      echo'<label for="exampleInputEmail1">Genero</label>';
      echo'<br>';
      echo'<input type="text" class="form-control" name="genero" id="genero" aria-describedby="emailHelp" placeholder="Ingrese Genero">';
      echo '<input type="hidden" name="album" value="' . $albumid . '">';
      echo '<input type="hidden" name="editar">';
      echo'</div>';
      echo'<button type="submit" class="btn btn-primary">Enviar</button>';
      echo'</form>';
      echo'<br>';

      echo'<form action="" method="POST">';
      echo'<div class="form-group">';
      echo'<label for="exampleInputEmail1">Fecha</label>';
      echo'<br>';
      echo'<input type="text" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelp" placeholder="Ingrese Fecha">';
      echo '<input type="hidden" name="album" value="' . $albumid . '">';
      echo '<input type="hidden" name="editar">';
      echo'</div>';
      echo'<button type="submit" class="btn btn-primary">Enviar</button>';
      echo'</form>';
      echo'<br>';

      echo "<br>";
    }

    echo "<form action='albumesartista.php'>";
    echo "<button type='submit' class='btn btn-link' name='volver'>Volver</button>";
    echo "</form>";

    echo '<form class="form-inline" action="albumsongs.php" method="post">';
    echo '<input class="form-control mr-sm-2" type="search" placeholder="Ingrese cancion" aria-label="Search"  name="busqueda">';
    echo '<input type="hidden" name="album" value="' . $albumid . '">';
    echo '<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>';
    echo '</form>';

    if(isset($_POST['busqueda'])){
        echo '<br>';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Nombre</th>';
        echo '<th scope="col">Artista</th>';
        echo '<th scope="col">Duración</th>';
        echo '<th scope="col"></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $index = 0;
        foreach($cancionesbuscadas as $cancionid){
          $cancion = new Cancion();
          $cancion->setCancion($cancionid);
          echo "<tr>";
          echo "<td>" . $cancion->getNombre() . "</td>";
          echo "<td>" . $cancion->getCreador() . "</td>";
          echo "<td>" . $cancion->getDuracion() . "</td>";
          echo "<form action='albumsongs.php'  method='post'>";
          echo '<td><button type="sumbit" name="añadirCancion" value="' . $cancion->getId() . '" class="btn btn-success">Añadir</button></td>';
          echo '<input type="hidden" name="album" value="' . $albumid . '">';
          echo "</form>";
          echo "</tr>";
          if($index == 4){
            break;
          }
          $index++;
        }
        
        echo '</tbody>';
        echo '</table>';

      }
    
    ?>
    <br>
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

<?php
include_once "user.php";
include_once "playlist.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['dejarseguir'])){
  $user->dejarSeguirPlaylist($_POST['dejarseguir']);
  //$playlistcreada = "Borrado correctamente!";
}

if(isset($_POST['seguir'])){
  $user->SeguirPlaylist($_POST['seguir']);
}

if(isset($_POST['gustarCancion'])){
  $cancionagregada = $_POST['gustarCancion'];
  $user->megustaCancion($cancionagregada);
}

$playlist = new Playlist();
if(isset($_POST['playlist'])){
    $playlistid = $_POST['playlist'];
    $playlist->setPlaylist($playlistid);
    $playlist->setSeguidores();
}

$canciones = $playlist->getCanciones();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title><?php echo $playlist->getNombre(); ?></title>
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
    <h3><?php echo $playlist->getNombre(); ?></h3>
    <p6>Creada por  <?php echo $playlist->getCreador() . "<br>"; ?></p6>
    <p4><?php echo $playlist->getNseguidores() . " Seguidores<br>";?></p4>
    <p4>Descripción: <?php echo $playlist->getDescripcion() . "<br>"; ?></p4>

    <?php
      if($user->playlistExists($playlistid)){
        echo "<form action='playlistsongs.php'  method='post'>";
        echo "<button type='submit' class='btn btn-link' name='dejarseguir' value='" . $playlist->getId() . "'>Dejar de seguir</button>";
        echo '<input type="hidden" name="playlist" value="' . $playlist->getId() . '">';
        echo "</form>";
      }else{
        echo "<form action='playlistsongs.php'  method='post'>";
        echo "<button type='submit' class='btn btn-link' name='seguir' value='" . $playlist->getId() . "'>Seguir</button>";
        echo '<input type="hidden" name="playlist" value="' . $playlist->getId() . '">';
        echo "</form>";
      }
    
    ?>

    <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Artista</th>
      <th scope="col">Duración</th>
      <th scope="col">Album</th>
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
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $cancion->getUser() . "'>" . $cancion->getCreador() . "</button></td>";
        echo "</form>";
        echo "<td>" . $cancion->getDuracion() . "</td>";
        echo "<form action='homealbum.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='homealbum' value='" . $cancion->getAlbumId() . "'>" . $cancion->getAlbum() . "</button></td>";
        echo "</form>";
        if(!$user->getIsArtista()){
          echo "<form action='playlistsongs.php'  method='post'>";
          echo '<td><button type="sumbit" name="gustarCancion" value="' . $cancion->getId() . '" class="btn btn-success">Me Gusta</button></td>';
          echo '<input type="hidden" name="playlist" value="' . $playlist->getId() . '">';
          echo "</form>";
        }else{
          echo "<td></td>";
        }
        echo "</tr>";
        $nsong++;
      }
    ?>
    </tbody>
    </table>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
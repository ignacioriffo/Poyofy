<?php
include_once 'user.php';
include_once 'cancion.php';
include_once 'album.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}
if(!isset($_POST['busqueda'])){
  header('Location: home.php');
}

$user = new User();
$user = $_SESSION['user'];

$canciones = array();

if(isset($_POST['gustarCancion'])){
  $cancionagregada = $_POST['gustarCancion'];
  $user->megustaCancion($cancionagregada);
}

if(isset($_POST['seguirPlaylist'])){
  $playlistagregada = $_POST['seguirPlaylist'];
  $user->seguirPlaylist($playlistagregada);
}

if(isset($_POST['seguirUsuario'])){
  $usuarioagregado = $_POST['seguirUsuario'];
  $user->seguirUsuario($usuarioagregado);
}

if(isset($_POST['busqueda'])){
    $busqueda = $_POST['busqueda'];
    $listabusqueda = $user->searchSongs($busqueda);
    $canciones = $listabusqueda[0];
    $playlists = $listabusqueda[1];
    $usuarios = $listabusqueda[2][0];
    $artistas = $listabusqueda[2][1];
    $albumes = $listabusqueda[3];

}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

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
    <h3>Canciones</h3>
    
    <table class="table">
    <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Artista</th>
      <th scope="col">Genero</th>
      <th scope="col">Fecha</th>
      <th scope="col">Duración</th>
      <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($canciones as $cancionid){
        $cancion = new Cancion();
        $cancion->setCancion($cancionid);
        echo "<tr>";
        echo "<td>" . $cancion->getNombre() . "</td>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $cancion->getUser() . "'>" . $cancion->getCreador() . "</button></td>";
        echo "</form>";
        echo "<td>" . $cancion->getGenero() . "</td>";
        echo "<td>" . $cancion->getFecha() . "</td>";
        echo "<td>" . $cancion->getDuracion() . "</td>";

        if(!$user->getIsArtista()){
          echo "<form action='busqueda.php'  method='post'>";
          echo '<td><button type="sumbit" name="gustarCancion" value="' . $cancion->getId() . '" class="btn btn-success">Me Gusta</button></td>';
          echo '<input type="hidden" name="busqueda" value="' . $busqueda . '">';
          echo "</form>";
        }else{
          echo "<td></td>";
        }
        echo "</tr>";
        if($index == 4){
          break;
        }
        $index++;
      }
    ?>
    
    </tbody>
    </table>

    <br>
    
    <h3>Albumes</h3>
    
    <table class="table">
    <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Artista</th>
      <th scope="col">Genero</th>
      <th scope="col">Fecha</th>
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($albumes as $albumid){
        $album = new Album();
        $album->setAlbum($albumid);
        echo "<tr>";
        echo "<form action='homealbum.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='homealbum' value='" . $albumid . "'>" . $album->getNombre() . "</button></td>";
        echo "</form>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $album->getUser() . "'>" . $album->getCreador() . "</button></td>";
        echo "</form>";
        echo "<td>" . $album->getGenero() . "</td>";
        echo "<td>" . $album->getFecha() . "</td>";
        echo "</tr>";
        if($index == 4){
          break;
        }
        $index++;
      }
    ?>
    
    </tbody>
    </table>






    
    <br>
    <h3>Playlists</h3>
    <table class="table">
    <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Creador</th>
      <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($playlists as $playlistid){
        $playlist = new Playlist();
        $playlist->setPlaylist($playlistid);
        echo "<tr>";
        echo "<form action='playlistsongs.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='playlist' value='" . $playlist->getId() . "'>" . $playlist->getNombre() . "</button></td>";
        echo "</form>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $playlist->getUser() . "'>" . $playlist->getCreador() . "</button></td>";
        echo "</form>";
        echo "<form action='busqueda.php'  method='post'>";
        echo '<td><button type="sumbit" name="seguirPlaylist" value="' . $playlist->getId() . '" class="btn btn-success">Seguir</button></td>';
        echo '<input type="hidden" name="busqueda" value="' . $busqueda . '">';
        echo "</form>";
        echo "</tr>";
        if($index == 4){
          break;
        }
        $index++;
      }
    ?>
    
    </tbody>
    </table>

    <br>
    <h3>Artistas</h3>
    <table class="table">
    <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($artistas as $artista){
        echo "<tr>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $artista->getId() . "'>" . $artista->getNombre() . "</button></td>";
        echo "</form>";
        echo "<form action='busqueda.php'  method='post'>";
        echo '<td><button type="sumbit" name="seguirUsuario" value="' . $artista->getId() . '" class="btn btn-success">Seguir</button></td>';
        echo '<input type="hidden" name="busqueda" value="' . $busqueda . '">';
        echo "</form>";
        echo "</tr>";
        if($index == 4){
          break;
        }
        $index++;
      }
    ?>
    
    </tbody>
    </table>

    <br>
    <h3>Usuarios</h3>
    <table class="table">
    <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($usuarios as $usuario){
        echo "<tr>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $usuario->getId() . "'>" . $usuario->getNombre() . "</button></td>";
        echo "</form>";
        echo "<form action='busqueda.php'  method='post'>";
        echo '<td><button type="sumbit" name="seguirUsuario" value="' . $usuario->getId() . '" class="btn btn-success">Seguir</button></td>';
        echo '<input type="hidden" name="busqueda" value="' . $busqueda . '">';
        echo "</form>";
        echo "</tr>";
        if($index == 4){
          break;
        }
        $index++;
      }
    ?>
    
    </tbody>
    </table>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
<?php
include_once "user.php";
include_once "playlist.php";
include_once 'album.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['dejarseguir'])){
  $user->dejarSeguirUsuario($_POST['dejarseguir']);
  //$playlistcreada = "Borrado correctamente!";
}

if(isset($_POST['seguir'])){
  $usuarioagregado = $_POST['seguir'];
  $user->seguirUsuario($usuarioagregado);
}

if(isset($_POST['gustarCancion'])){
  $cancionagregada = $_POST['gustarCancion'];
  $user->megustaCancion($cancionagregada);
}

if(isset($_POST['seguirPlaylist'])){
  $playlistagregada = $_POST['seguirPlaylist'];
  $user->seguirPlaylist($playlistagregada);
}

$uservisita = new User();
if(isset($_POST['seguido'])){
    $idseguido = $_POST['seguido'];
    $uservisita->setUser("",$idseguido);
}

$playlists = $uservisita->getPlaylists();
if(!$uservisita->getIsArtista()){
  $canciones = $uservisita->getCanciones();
  $albumes = array();
}else{
  $canciones = $uservisita->getCancionesArtista();
  $albumes = $uservisita->getAlbumesArtista();
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
    <h3><?php echo $uservisita->getNombre(); ?></h3>
    <p6><?php echo $uservisita->getSeguidores() . " "; ?>Seguidores</p6>

    <?php
    if($user->seguidoExists($idseguido)){
      echo "<form action='visitausuario.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='dejarseguir' value='" . $uservisita->getId() . "'>Dejar de seguir</button>";
      echo '<input type="hidden" name="seguido" value="' . $uservisita->getId() . '">';
      echo "</form>";
    }else{
      echo "<form action='visitausuario.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='seguir' value='" . $uservisita->getId() . "'>Seguir</button>";
      echo '<input type="hidden" name="seguido" value="' . $uservisita->getId() . '">';
      echo "</form>";
    }
    ?>

    <br>
    <h3>Canciones</h3>

    <table class="table">
    <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Artista</th>
      <th scope="col">Duración</th>
      <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($canciones as $cancion){
        echo "<tr>";
        echo "<td>" . $cancion->getNombre() . "</td>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $cancion->getUser() . "'>" . $cancion->getCreador() . "</button></td>";
        echo "</form>";
        echo "<td>" . $cancion->getDuracion() . "</td>";

        if(!$user->getIsArtista()){
          echo "<form action='visitausuario.php'  method='post'>";
          echo '<td><button type="sumbit" name="gustarCancion" value="' . $cancion->getId() . '" class="btn btn-success">Me Gusta</button></td>';
          echo '<input type="hidden" name="seguido" value="' . $uservisita->getId() . '">';
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

    <?php
    if($uservisita->getIsArtista()){
    echo '<h3>Albumes</h3>';
    
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Nombre</th>';
    echo '<th scope="col">Artista</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
      $index = 0;
      foreach($albumes as $album){
        echo "<tr>";
        echo "<form action='homealbum.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='homealbum' value='" . $album->getId() . "'>" . $album->getNombre() . "</button></td>";
        echo "</form>";
        echo "<td>" . $album->getCreador() . "</td>";
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
      foreach($playlists as $playlist){
        echo "<tr>";
        echo "<td>" . $playlist->getNombre() . "</td>";
        echo "<td>" . $playlist->getCreador() . "</td>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo '<td><button type="sumbit" name="seguirPlaylist" value="' . $playlist->getId() . '" class="btn btn-success">Seguir</button></td>';
        echo '<input type="hidden" name="seguido" value="' . $uservisita->getId() . '">';
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
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
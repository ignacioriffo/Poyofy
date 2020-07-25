<?php
include_once 'user.php';
include_once 'cancion.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

$canciones = array();

if(isset($_POST['busqueda'])){
    $busqueda = $_POST['busqueda'];
    $listabusqueda = $user->searchSongs($busqueda);
    $canciones = $listabusqueda[0];
    $playlists = $listabusqueda[1];
    $personas = $listabusqueda[2];

    $usuarios = array();
    $artistas = array();

    foreach($personas as $personaid){
      $persona = new User();
      $persona->setUser("", $personaid);

      if($persona->getIsArtista()){
        array_push($artistas,$persona);
      }else{
        array_push($usuarios,$persona);
      }
    }

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
      <th scope="col">Duración</th>
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
        echo "<td>" . $cancion->getCreador() . "</td>";
        echo "<td>" . $cancion->getDuracion() . "</td>";
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
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($playlists as $playlistid){
        $playlist = new Playlist();
        $playlist->setPlaylist($playlistid);
        echo "<tr>";
        echo "<td>" . $playlist->getNombre() . "</td>";
        echo "<td>" . $playlist->getCreador() . "</td>";
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
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($artistas as $artista){
        echo "<tr>";
        echo "<td>" . $artista->getNombre() . "</td>";
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
    </tr>
    </thead>
    <tbody>
    <?php
      $index = 0;
      foreach($usuarios as $usuario){
        echo "<tr>";
        echo "<td>" . $usuario->getNombre() . "</td>";
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
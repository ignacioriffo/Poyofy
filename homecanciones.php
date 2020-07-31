<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['nomegusta'])){
  $cancionid = $_POST['nomegusta'];
  $user->nomegustaCancion($cancionid);
}

$canciones = $user->getCanciones();

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
    <h3>Canciones</h3>
    
    <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Artista</th>
      <th scope="col">Genero</th>
      <th scope="col">Fecha</th>
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
        //echo "<td>" . $cancion->getCreador() . "</td>";
        echo "<form action='visitausuario.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='seguido' value='" . $cancion->getUser() . "'>" . $cancion->getCreador() . "</button></td>";
        echo "</form>";
        echo "<td>" . $cancion->getGenero() . "</td>";
        echo "<td>" . $cancion->getFecha() . "</td>";
        echo "<td>" . $cancion->getDuracion() . "</td>";
        echo "<form action='homealbum.php'  method='post'>";
        echo "<td><button type='submit' class='btn btn-link' name='homealbum' value='" . $cancion->getAlbumId() . "'>" . $cancion->getAlbum() . "</button></td>";
        echo "</form>";
        echo "<form action='homecanciones.php'  method='post'>";
        echo '<td><button type="sumbit" name="nomegusta" value="' . $cancion->getId() . '" class="btn btn-light">Borrar</button></td>';
        echo "</form>";
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
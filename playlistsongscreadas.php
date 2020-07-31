<?php
include_once "user.php";
include_once "playlist.php";
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['playlisteditada'])){
  $user->editarNombrePlaylist($_POST['playlisteditada'], $_POST['playlist']);
}

if(isset($_POST['descripcion'])){
  $user->editarDescripcionPlaylist($_POST['descripcion'], $_POST['playlist']);
}

$playlist = new Playlist();
if(isset($_POST['playlist'])){
    $playlistid = $_POST['playlist'];
    $playlist->setPlaylist($playlistid);
    $playlist->setSeguidores();
}

if(isset($_POST['busqueda'])){
  $cancionbuscada = $_POST['busqueda'];
  $listabusqueda = $user->searchSongs($cancionbuscada);
  $cancionesbuscadas = $listabusqueda[0];
}

if(isset($_POST['añadirCancion'])){
  $cancionañadida = $_POST['añadirCancion'];
  $playlist->añadirCancion($cancionañadida);
}

if(isset($_POST['borrar'])){
  $cancionid = $_POST['borrar'];
  $playlist->borrarCancion($cancionid);
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
      echo "<form action='' method='post'>";
      echo "<button type='submit' class='btn btn-link' name='editar'>Editar</button>";
      echo '<input type="hidden" name="playlist" value="' . $playlistid . '">';
      echo "</form>";

      if(isset($_POST['editar'])){
        echo "<br>";
        echo'<form action="" method="POST">';
        echo'<div class="form-group">';
        echo'<label for="exampleInputEmail1">Nombre Playlist</label>';
        echo'<br>';
        echo'<input type="text" class="form-control" name="playlisteditada" id="playlisteditada" aria-describedby="emailHelp" placeholder="Ingrese Nombre">';
        echo '<input type="hidden" name="playlist" value="' . $playlistid . '">';
        echo '<input type="hidden" name="editar">';
        echo'</div>';
        echo'<button type="submit" class="btn btn-primary">Enviar</button>';
        echo'</form>';
        echo'<br>';

        echo'<form action="" method="POST">';
        echo'<div class="form-group">';
        echo'<label for="exampleInputEmail1">Descripcion</label>';
        echo'<br>';
        echo'<input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="emailHelp" placeholder="Ingrese Descripcion">';
        echo '<input type="hidden" name="playlist" value="' . $playlistid . '">';
        echo '<input type="hidden" name="editar">';
        echo'</div>';
        echo'<button type="submit" class="btn btn-primary">Enviar</button>';
        echo'</form>';
        echo'<br>';
      }

      echo "<form action='playlistcreadas.php'>";
      echo "<button type='submit' class='btn btn-link' name='volver'>Volver</button>";
      echo "</form>";
    
      echo '<form class="form-inline" action="playlistsongscreadas.php" method="post">';
      echo '<input class="form-control mr-sm-2" type="search" placeholder="Ingrese cancion" aria-label="Search"  name="busqueda">';
      echo '<input type="hidden" name="playlist" value="' . $playlistid . '">';
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
          echo "<form action='playlistsongscreadas.php'  method='post'>";
          echo '<td><button type="sumbit" name="añadirCancion" value="' . $cancion->getId() . '" class="btn btn-success">Añadir</button></td>';
          echo '<input type="hidden" name="playlist" value="' . $playlistid . '">';
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
        echo "<form action='playlistsongscreadas.php'  method='post'>";
        echo '<td><button type="sumbit" name="borrar" value="' . $cancion->getId() . '" class="btn btn-light">Borrar</button></td>';
        echo '<input type="hidden" name="playlist" value="' . $playlistid . '">';
        echo "</form>";
        echo "</tr>";
        $nsong++;
      }
    ?>
    </tbody>
    </table>
    <?php
      echo "<form action='playlistcreadas.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='borrarplaylist' value='" . $playlist->getId() . "'>Borrar playlist</button>";
      echo "<br>";
    ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
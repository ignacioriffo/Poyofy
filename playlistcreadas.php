<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['borrarplaylist'])){
    $user->borrarPlaylist($_POST['borrarplaylist']);
    $playlistcreada = "Borrado correctamente!";
}


$playlists = $user->getPlaylistsCreadas();

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
    <nav class="nav">
	<a class="nav-link disabled" href="#"  aria-disabled="true"> <?php echo $user->getNombre(); ?></a>
    <a class="nav-link disabled" href="#"  aria-disabled="true">Playlist Creadas</a>
	<a class="nav-link" href="home.php">Volver</a>
	<a class="nav-link" href="logout.php">Cerrar sesión</a>
	</nav>
    <div class="container">
    <h1>Playlist Creadas</h1>
    <?php
    	echo "<form action='playlistsongscreadas.php' method='post'>";
        foreach($playlists as $playlist){
            $playlistname = $playlist->getNombre();
            $playlistid = $playlist->getId();
            echo "<button type='submit' class='btn btn-link' name='playlist' value='" . $playlistid . "'>" . $playlistname . "</button>";
            echo "<br>";
        }
        echo "</form>";

        echo "<form action='crearplaylist.php'>";
        echo "<button type='submit' class='btn btn-link' name='crearplaylist'>Crear playlist</button>";
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
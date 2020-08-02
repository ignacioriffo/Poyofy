<?php
include_once 'user.php';
session_start();

if(!isset($_SESSION['user'])){
  header('Location: login.php');
}

$user = new User();
$user = $_SESSION['user'];

if(isset($_POST['borrarcuenta'])){
  $user->borrarCuenta();
  header('Location: logout.php');
}

if(isset($_POST['newbiografia'])){
  $user->editarBiografia($_POST['newbiografia']);
}

if(isset($_POST['username'])){
  $infoname = $user->editarNombre($_POST['username']);
}

if(isset($_POST['password'])){
  $infopass = $user->editarPass($_POST['password']);
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
    <h3>Perfil</h3>
    <br>

    <h3>Nombre de usuario</h3>
    <?php
		if(isset($infoname)){
            echo $infoname;
            echo "<br>";
		}
	  ?>
    <p6><?php echo $user->getNombre(); ?></p6>
    <form action="editarperfil.php" method="POST">
    <div class="form-group">
    <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Ingrese Nombre">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <br>
    <br>

    <h3>Contraseña</h3>
    <?php
		if(isset($infopass)){
            echo $infopass;
		}
	  ?>
    <form action="editarperfil.php" method="POST">
    <div class="form-group">
    <input type="text" class="form-control" name="password" id="password" placeholder="Ingrese Contraseña">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <br>
    <br>

    <?php
      if($user->getIsArtista()){
        echo '<h3>Biografia</h3>';
        echo "<h6>" . $user->getBiografia() . "</h6>";

        echo '<form action="editarperfil.php" method="POST">';
        echo '<div class="form-group">';
        echo '<label for="exampleFormControlTextarea1">Editar Biografia</label>';
        echo '<textarea class="form-control" name="newbiografia" id="newbiografia" rows="3"></textarea>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Enviar</button>';
        
        echo '</form>';
      }

      
      echo "<form action='editarperfil.php'  method='post'>";
      echo "<button type='submit' class='btn btn-link' name='borrarcuenta' value='" . $user->getId() . "'>Borrar cuenta</button>";
      echo "</form>";
    ?>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
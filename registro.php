<?php

include_once 'conexion2.php';
include_once 'user.php';

$user = new User();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['opcion'])){
	$userForm = $_POST['username'];
    $passForm = $_POST['password'];
    $typeForm = $_POST['opcion'];
    $seguidores = 0;

	if($user->registroExists($userForm)){
        $error = "Nombre de usuario no esta disponible!";
		include_once 'registro.php';
	}else{
        $user->insertUser($userForm,$passForm,$typeForm,$seguidores);
        $usercreado = "Cuenta creada correctamente!";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <nav class="nav">
	<a class="nav-link" href="login.php">Iniciar Sesión</a>
	</nav>
    <div class="container">
	<h3>Crea tu cuenta en Poyofy!</h3>
    <?php
		if(isset($error)){
            echo $error;
		}
	?>
	<form action="" method="POST">
	<div class="form-group">
		<label for="exampleInputEmail1">Nombre de usuario</label>
		<input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Ingrese Nombre">
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Contraseña</label>
		<input type="password" class="form-control" name="password" id="password" placeholder="Ingrese Contraseña">
	</div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="opcion" id="usuario" value="usuario">
        <label class="form-check-label" for="usuario">usuario</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="opcion" id="artista" value="artista">
        <label class="form-check-label" for="artista">artista</label>
    </div>
        <br>
	    <button type="submit" class="btn btn-primary">Registrarse</button>
	</form>
    <?php
		if(isset($usercreado)){
            echo $usercreado;
		}
	?>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
<?php

include_once 'user.php';
include_once 'user_session.php';

$userSession = new UserSession();
$user = new User();
/*
$isartista = $userTemp->isArtista($userForm, $passForm);
if($isartista){
	$user = new Artista;
}else{
	$user = new User;
}*/

if(isset($_SESSION['user'])){
	$username = $userSession->getCurrentUser();
	$user->setUser($userSession->getCurrentUser());
	$user->isArtista($user->getId());

	if($user->getIsArtista()){
		$user->setBiografia($user->getId());
	}
	include_once 'home.php';
}else if (isset($_POST['username']) && isset($_POST['password'])) {
	$userForm = $_POST['username'];
	$passForm = $_POST['password'];

	if($user->userExists($userForm, $passForm)){
		$userSession->setCurrentUser($userForm);

		$user->setUser($userForm);
		$user->isArtista($user->getId());

		if($user->getIsArtista()){
			$user->setBiografia($user->getId());
		}
		include_once 'home.php';
	}else{
		$errorLogin = "nombre de usuario y/o contraseña incorrecta";
		include_once 'login.php';
	}
}else{
	include_once 'login.php';
}
?>
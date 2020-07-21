<?php

include_once 'user.php';
include_once 'user_session.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$userSession = new UserSession();
$user = new User();
/**/
$username = $userSession->getCurrentUser();
$user->setUser($userSession->getCurrentUser());
$user->isArtista($user->getId());

if($user->getIsArtista()){
	$user->setBiografia($user->getId());
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Playlist</title>
</head>
<body>
	<h1>Playlists</h1>
	

	<li class="volver">
		<a href="index.php">Volver</a>
	</li>
</body>
</html>
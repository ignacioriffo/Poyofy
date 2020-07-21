<?php

include_once 'user.php';
include_once 'user_session.php';

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
    <title>Document</title>
</head>
<body>
    <
</body>
</html>
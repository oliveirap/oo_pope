<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$login = new Login("Piroquinha", "123456");
$login->tryLogin();
$watcher = new Watchers();
var_dump($watcher->isLogged());
$watcher->userOnly();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>POPE</title>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<label for="username">User</label> <input type="text" name="username"><br><br>
		<label for="password">Pass</label> <input type="password" name="password"><br><br>
		<input type="submit">	
	</form>
	
</body>
</html>
<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->watchLogin();
$watcher->publicOnly();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>POPE</title>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<label for="username">User</label>
		<input type="text" name="username" <?php echo (!!getPost('username')) ? "value='" . getPost('username') . "'" : null ?>>
		<br><br>
		<label for="password">Pass</label>
		<input type="password" name="password">
		<br><br>
		<input type="submit" name="login" value="Login">	
	</form>
	<a href="views/">Views</a>
</body>
</html>
<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->userOnly();
$watcher->watchLogout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nova Lista</title>
</head>
<body>
	<?php 
		require_once(DIR_PARTIALS . "nav.php");
	?>

	<form action="?">
		<label>Nome da Lista<br><input type="text" name="test-name"></label>
		<br>
		<br>
		<label>tags<br><input type="text" name="test-tags"></label>
		<br>
		<br>
		<label>Descrição
		<br>
		<textarea name="test-description" cols="30" rows="10"></textarea></label>
		<br>
		<br>
		<label>Dificuldade</label>
		<br>
		<label><input type="radio" value="1" name="test-difficulty"> Fácil </label>
		<br>
		<label><input type="radio" value="2" name="test-difficulty"> Médio </label>
		<br>
		<label><input type="radio" value="3" name="test-difficulty"> Dificil </label>
		<br>
		<br>
		<input type="submit" name="submitNewList" value="Cadastrar">
	</form>

</body>
</html>
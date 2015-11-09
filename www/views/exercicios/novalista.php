<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->adminOnly();
$watcher->watchLogout();
$wasSet = $watcher->watchNewTest();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nova Lista</title>
<style>
table, tr, td
{
	border: 1px solid black;
	border-collapse: collapse;

}
td{
	padding: 5px;
}	
</style>
</head>
<body>
	<?php 
		require_once(DIR_PARTIALS . "nav.php");
	?>
	<form action="?" id="newTest" method="POST">
		<label>Nome da Lista<br><input type="text" name="testName"></label>
		<br>
		<br>
		<label>tags<br><input type="text" name="testTags"></label>
		<br>
		<br>
		<label>Descrição
		<br>
		<textarea name="testDescription" cols="30" rows="10"></textarea></label>
		<br>
		<br>
		<label>Dificuldade</label>
		<br>
		<label><input type="radio" value="1" name="testDifficulty"> Fácil </label>
		<br>
		<label><input type="radio" value="2" name="testDifficulty"> Médio </label>
		<br>
		<label><input type="radio" value="3" name="testDifficulty"> Dificil </label>
		<br>
		<label>Tags</label>
		<label><input type="checkbox" class="tagCheck" name="tags[]" value="mecanica">Mecanica</label>
		<label><input type="checkbox" class="tagCheck" name="tags[]" value="cinematica">Cinematica</label>
		<br>
		<label>Dificuldade</label>
		<label><input type="checkbox" class="difCheck" name="dificuldade[]" value="1">Fácil</label>
		<label><input type="checkbox" class="difCheck" name="dificuldade[]" value="2">Média</label>
		<label><input type="checkbox" class="difCheck" name="dificuldade[]" value="3">Dificil</label>
		<a href="#" data-role='button' id="buscar">Buscar</a>
		<br>
		<br>
		<div id="qholder">
			<table>
				<tr>
					<td>Usar</td>
					<td>Enunciado</td>
					<td>Alternativas</td>
					<td>Correta</td>			
				</tr>				
			</table>
		</div>
		<input type="submit" name="submitNewTest" value="Cadastrar">
	</form>
	<div id="linkholder"></div>
	<?php if (isset($wasSet)) {
		echo($wasSet['msg']);
	} ?>

	<script src="../../assets/js/jquery.js"></script>
	<script src="../../assets/js/custom.js"></script>
	<script src="../../assets/lib/paginator.js"></script>
</body>
</html>
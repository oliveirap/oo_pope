<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->userOnly();
$watcher->watchLogout();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Nova Questão</title>

	<!-- Library -->
	<script src="../../assets/lib/wysihtml/dist/wysihtml-toolbar.min.js"></script>
	<!-- wysihtml5 parser rules -->
	<script src="../../assets/lib/wysihtml/parser_rules/advanced.js"></script>
</head>
<body>
<?php require_once(DIR_PARTIALS . "nav.php") ?>
<p>Olá, <?php echo firstName(getInfo('name')) ?>.</p>
<p>Esta página é exclusiva de administradores.</p>

<!-- Toolbar do editor -->
<div id="question-toolbar">
  <a data-wysihtml5-command="bold">Negrito</a>
  <a data-wysihtml5-command="italic">Itálico</a>
  <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">Titulo 1</a>
  <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3">Subtitulo</a>
  <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="p">P</a>
 </div>
<!-- Corpo do Editor -->
<form action="?" method="POST">
    <textarea id="question-body" placeholder="Insira o enunciado da questão" name="question-body" autofocus></textarea>
	<br>
	<br>
	<input type="radio" value="alt-1" name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta"></input>
	<br>
	<br>
	<input type="radio" value="alt-2" name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta"></input>
	<br>
	<br>
	<input type="radio" value="alt-3" name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta"></input>
	<br>
	<br>
	<input type="radio" value="alt-4" name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta"></input>
	<br>
	<br>
	<input type="radio" value="alt-5" name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta"></input>
	<br>
	<br>
	<input type="text" name="question-tags" placeholder="Tags">
	<br>
	<br>
	<input type="submit" name="submit" value="Cadastrar">
</form>
 
<!-- Inicializa editor -->
<script>
  var editor = new wysihtml5.Editor('question-body', {
    toolbar: 'question-toolbar',
    parserRules:  wysihtml5ParserRules // defined in file parser rules javascript
  });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<?php 
	if(isset($_POST['submit']))
	{
		if(!empty($_POST['answer-text']) && array_filter($_POST['answer-text']))
		{
			$answers = array_filter($_POST['answer-text']);
			foreach ($answers as $key => $value) {
				$i = $key + 1;
				if($_POST['question-answer'] == "alt-$i")
				{
					echo "Correta ->";
				}
				print_r($value);
				echo "<br>";
			}
		}
		isset($_POST['question-tags']) ? print_r($_POST['question-tags']) : null;
		echo "<br>";
		isset($_POST['question-body']) ? print_r($_POST['question-body']) : null;
		echo "<br>";
		print_r($_POST);	
	}
?>
</body>
</html>
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
<?php require_once(DIR_PARTIALS . "nav.php"); ?>
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
    <textarea id="question-body" placeholder="Insira o enunciado da questão" name="question-body" autofocus><?php echo isset($_POST['question-body']) ? $_POST['question-body'] : null ?></textarea>
	<br>
	<br>
	<input type="radio" value="alt-1" <?php if(getPost('question-answer') == 'alt-1') echo "checked" ?> name="question-answer"><input type="text" name="answer-text[]" <?php echo isset($_POST['answer-text'][0]) ? "value='" . $_POST['answer-text'][0] . "'" : null ?> placeholder="Corpo da resposta"></input>
	<br>
	<br>
	<input type="radio" value="alt-2" <?php if(getPost('question-answer') == 'alt-2') echo "checked" ?> name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta" <?php echo isset($_POST['answer-text'][1]) ? "value='" . $_POST['answer-text'][1] . "'" : null ?>></input>
	<br>
	<br>
	<input type="radio" value="alt-3" <?php if(getPost('question-answer') == 'alt-3') echo "checked" ?> name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta" <?php echo isset($_POST['answer-text'][2]) ? "value='" . $_POST['answer-text'][2] . "'" : null ?>></input>
	<br>
	<br>
	<input type="radio" value="alt-4" <?php if(getPost('question-answer') == 'alt-4') echo "checked" ?> name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta" <?php echo isset($_POST['answer-text'][3]) ? "value='" . $_POST['answer-text'][3] . "'" : null ?>></input>
	<br>
	<br>
	<input type="radio" value="alt-5" <?php if(getPost('question-answer') == 'alt-5') echo "checked" ?> name="question-answer"><input type="text" name="answer-text[]" placeholder="Corpo da resposta" <?php echo isset($_POST['answer-text'][4]) ? "value='" . $_POST['answer-text'][4] . "'" : null ?>></input>
	<br>
	<br>
	<input type="text" name="question-tags" placeholder="Tags" <?php echo isset($_POST['question-tags']) ? "value='" . $_POST['question-tags'] . "'" : null ?>>
	<br>
	<br>
	<label>Dificuldade</label>
	<br>
	<label><input type="radio" value="1" name="question-difficulty"> Fácil </label>
	<br>
	<label><input type="radio" value="2" name="question-difficulty"> Médio </label>
	<br>
	<label><input type="radio" value="3" name="question-difficulty"> Dificil </label>
	<br>
	<br>
	<input type="submit" name="submitNewQuestion" value="Cadastrar">
</form>
<?php 
$wasSet = $watcher->watchNewQuestion();
echo isset($wasSet) ? $wasSet['msg'] : null;

?>
<!-- Inicializa editor -->
<script>
  var editor = new wysihtml5.Editor('question-body', {
    toolbar: 'question-toolbar',
    parserRules:  wysihtml5ParserRules // defined in file parser rules javascript
  });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</body>
</html>
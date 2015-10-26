<?php 
//DB
define("DB_NAME", "pope");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_PREFIX", "pp_");
define("DB_CHARSET", "utf8");
//URLS
define("URL_BASE", "http://pope.dev:8080/oo_pope/www/");
//views
define("URL_VIEWS", URL_BASE . "views/");
define("URL_REGISTRO", URL_VIEWS . "registro/");
define("URL_PAINEL", URL_VIEWS . "painel/");
define("URL_NEW_QUESTION", URL_VIEWS . "exercicios/cadastrar.php");
define("URL_ANSWER_TEST", URL_VIEWS . "exercicios/")/
//DIRS
define("DIR_BASE", $_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/");
define("DIR_SRC", DIR_BASE . "src/");
define("DIR_CSS", DIR_BASE . "assets/css/");
define("DIR_IMG", DIR_BASE . "assets/img/");
define("DIR_JS", DIR_BASE . "assets/js/");
define("DIR_LIB", DIR_BASE . "assets/lib/");
define("DIR_CLASSES", DIR_SRC . "classes/");
define("DIR_PARTIALS", DIR_BASE . "assets/partials/");
define("DIR_WYSIHTML", DIR_BASE  . "assets/lib/wysihtml/");
//ARQUIOS
define("FILE_AUTOLOADER", DIR_SRC . "autoloader.php");
define("FILE_HEADER", DIR_PARTIALS . "header.php");
define("FILE_FOOTER", DIR_PARTIALS . "footer.php");
//$_SESSION
?>
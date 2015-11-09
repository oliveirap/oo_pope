<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
/**
 * Actions code:
 * 		[1] Retriever::retrieveQuestion();
 *			?page= page for pagination, ?view= results per page.
 *		[2] Retriever::retrieveTest();
 *		[3] Retriever::retrieveTags();
 *
 */
	$action = (!empty($_GET['action'])) ? $_GET['action'] : null; 
	if($action == 1)
	{
		$page      = (!empty($_GET['page'])) ? (int)$_GET['page'] : 1;
		$perPage   = (!empty($_GET['view'])) ? (int)$_GET['view'] : 5;
		$tags      = thePost('tags');
		$diff      = thePost('diff');
		$retriever = new Retriever();
		$data      = $retriever->retrieveQuestion($tags, $diff);
		$paginator = new Paginator($perPage, 5, $data);
		$data      = $paginator->plotResults($page);
		echo json_encode($data);
	}
	else if($action == 2)
	{
		$page      = (!empty($_GET['page'])) ? (int)$_GET['page'] : 1;
		$perPage   = (!empty($_GET['view'])) ? (int)$_GET['view'] : 5;
		$tags      = thePost('tags');
		$diff      = thePost('diff');
		$retriever = new Retriever();
		$data      = $retriever->retrieveTest($tags, $diff);
		$paginator = new Paginator($perPage, 5, $data);
		$data      = $paginator->plotResults($page);
		echo json_encode($data);
	}
	else if($action == 3)
	{
		$tags      = thePost('tags');
		$retriever = new Retriever();
		echo json_encode($retriever->retrieverTags($tags));
	}

?>
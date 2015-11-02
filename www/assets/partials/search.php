<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
/**
 * Actions code:
 * 		[1] Retriever::retrieveQuestion();
 *			?page= page for pagenation
 *		[2] Retriever::retrieveTest();
 *		[3] Retriever::retrieveTags();
 *		[4] Paginator
 *			?fn codes
 *				[1]
 */
	$action = (!empty($_GET['action'])) ? $_GET['action'] : null; 
	if($action == 1)
	{
		$page      = (!empty($_GET['page'])) ? $_GET['page'] : 1; 
		$tags      = thePost('tags');
		$diff      = thePost('diff');
		$retriever = new Retriever();
		$data      = $retriever->retrieveQuestion($tags, $diff);
		return $data;
	}
	else if($action == 2)
	{
		$tags      = thePost('tags');
		$diff      = thePost('diff');
		$retriever = new Retriever();
		echo json_encode($retriever->retrieveTest($tags, $diff));		
	}
	else if($action == 3)
	{
		$tags      = thePost('tags');
		$retriever = new Retriever();
		echo json_encode($retriever->retrieverTags($tags));
	}

?>
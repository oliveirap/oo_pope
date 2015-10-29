<?php
/**
 * POPE Retriever Class
 * Functions to return elements of a database. 
 * @category  SELECT Queries, return objects
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/

class Retriever
{
	/**
	 * Retrieves tests from pp_tests. All params are WHERE filters.
	 * @uses Database::
	 * @param $tags Tags filter
	 * @param $diff Difficulty filter
	 * @return $questions Object
	 */
	public function retrieveQuestion($tags = null, $diff = null)
	{
		$db = Conectar();
		if(!empty($tags))
		{
			if(is_array($tags))
			{
				$tags = array_filter($tags);
				foreach ($tags as $key => $value) {
					
				}
			}
		}
	}
	
}
?>
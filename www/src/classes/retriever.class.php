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
	 * Retrieves questions from pp_questions. All params are WHERE filters.
	 * @uses Database::
	 * @param $tags Tags filter
	 * @param $diff Difficulty filter
	 * @return $questions Object
	 */
	public function retrieveQuestion($tags = null, $diff = null)
	{
		$db   = Conectar();
		$tags = escape($tags);
		$diff = escape($diff);
		/** WHERE CONDITIONS **/
		$where = "WHERE 1";
		if(!empty($tags))
		{
			if(is_array($tags) && $tags = array_filter($tags))
			{
				$where   .= " AND ";
				$firstkey = key($tags);
				end($tags);
				$lastkey = key($tags);
				foreach ($tags as $key => $value)
				{
					if($key == $firstkey)
					{
						$where .= "(";
					}
					$where .= "tag LIKE '%$value%' ";
					if($key != $lastkey)
					{
						$where .= "OR ";
					}
					else
					{
						$where  = rtrim($where);
						$where .= ")";
					}
				}
			}
			else
			{
				$where .= " AND tag LIKE '%$tags%'";
			}
		}
		if(!empty($diff))
		{
			if(is_array($diff) && $diff = array_filter($diff))
			{
				$where .= " AND ";
				$firstkey = key($diff);
				end($diff);
				$lastkey = key($diff);
				foreach ($diff as $key => $value)
				{
					if($key == $firstkey)
					{
						$where .= "(";
					}
					$where .= "difficulty LIKE $value ";
					if($key != $lastkey)
					{
						$where .= "OR ";
					}
					else
					{
						$where  = rtrim($where);
						$where .= ")";
					}
				}
			}
			else
			{
				$where .= " AND difficulty LIKE $diff";
			}
		}
		$where = rtrim($where);

		/** THE QUERY **/
		$tb   = DB_PREFIX . "questions";
		$sql  = "SELECT * FROM $tb $where";
		$data = $db->query($sql)->fetch();
		return $data;
	}
	
	/**
	 * Retrieve tests from pp_tests. All params are filters
	 * @uses Database::
	 * @param $tags Tags filter
	 * @param $diff Difficulty filter
	 * @return $data Object with retrieved lists.
	 */
	public function retrieveTest($tags = null, $diff = null)
	{
		$db   = Conectar();
		$tags = escape($tags);
		$diff = escape($diff);

		/** WHERE CONDITIONS **/
		$where = "WHERE 1";
		if(!empty($tags))
		{
			if(is_array($tags) && $tags = array_filter($tags))
			{
				$where   .= " AND ";
				$firstkey = key($tags);
				end($tags);
				$lastkey = key($tags);
				foreach ($tags as $key => $value)
				{
					if($key == $firstkey)
					{
						$where .= "(";
					}
					$where .= "tag LIKE '%$value%' ";
					if($key != $lastkey)
					{
						$where .= "OR ";
					}
					else
					{
						$where  = rtrim($where);
						$where .= ")";
					}
				}
			}
			else
			{
				$where .= " AND tag LIKE '%$tags%'";
			}
		}
		if(!empty($diff))
		{
			if(is_array($diff) && $diff = array_filter($diff))
			{
				$where .= " AND ";
				$firstkey = key($diff);
				end($diff);
				$lastkey = key($diff);
				foreach ($diff as $key => $value)
				{
					if($key == $firstkey)
					{
						$where .= "(";
					}
					$where .= "difficulty LIKE $value ";
					if($key != $lastkey)
					{
						$where .= "OR ";
					}
					else
					{
						$where  = rtrim($where);
						$where .= ")";
					}
				}
			}
			else
			{
				$where .= " AND difficulty LIKE $diff";
			}
		}
		$where = rtrim($where);

		/** THE QUERY **/
		$tb   = DB_PREFIX . "tests";
		$sql  = "SELECT * FROM $tb $where";
		$data = $db->query($sql)->fetch();
		return $data;
	}

	/**
	 * Retrieves all tags from pp_tags
	 * @uses Database:
	 * @param $tag a specific tag to look for.
	 * @return $data('tag' => numberOfQuestions ) with all tags;
	 */
	public function retrieveTags($tags = null)
	{
		if($tags == null)
		{
			echo "null";
			$db   = Conectar();
			$data = $db->select()->from('tags')->fetch();
			return $data;
		}
		else if(!is_array($tags))
		{
			$db    = Conectar();
			$tags  = escape($tags);
			$where = array("code" => $tags);
			$data  = $db->select()->from('tags')->where($where)->fetch();
			return $data;
		}
		else
		{
			$tags     = escape(array_filter($tags));
			$where    = "WHERE 1 AND ";
			$firstkey = key($tags);
			end($tags);
			$lastkey  = key($tags);
			foreach ($tags as $key => $value)
			{
				if($key == $firstkey)
				{
					$where .= "(";
				}
				$where .= "code LIKE '%$value%' ";
				if($key != $lastkey)
				{
					$where .= "OR ";
				}
				else
				{
					$where  = rtrim($where);
					$where .= ")";
				}
			}

			/** THE QUERY **/
			$db   = Conectar();
			$tb   = DB_PREFIX . "tags";
			$data = $db->query("SELECT * FROM $tb $where")->fetch();
			$data = array_filter($data);
			return $data;
		}
	}
	
}
?>
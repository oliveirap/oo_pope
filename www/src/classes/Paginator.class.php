<?php
/**
 * POPE Paginator Class
 * For pagination and such.
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/

class Paginator
{
	protected $perPage     = 0;
	protected $currentPage = 1;
	protected $pageRange   = 5;
	protected $maxPages    = 1;
	protected $results;
	protected $numberOfResults;

	/**
	 * Builds the instance.
	 * @param $perPage number os results perPage.
	 * @param $results the results array.
	 */
	function __construct($perPage = 0, $pageRange = 5, $results)
	{
		if($perPage > 0 && is_int($perPage))
		{
			$this->perPage = $perPage;
		}
		if(is_array($results) && array_filter($results))
		{
			$this->results         = $results;
			$this->numberOfResults = count($results);
			if($this->perPage != 0)
			{
				$this->maxPages = ceil($this->numberOfResults / $this->perPage);
			} 
		}
		if(is_int($pageRange) && $pageRange != 5 && $pageRange >  0)
		{
			$this->pageRange = $pageRange;
		}
	}

	/**
	 * Sets the results array.
	 * @param $results the results array
	 */
	public function setResults($results)
	{
		if(is_array($results))
		{
			$results       = array_filter($results);
			$this->results = $results;
		}
	}

	/**
	 * Plots the result to show on the page
	 * @param $page the page to plot.
	 * @return $plot() the array of results.
	 */
	public function plotResults($page = 0)
	{
		if(is_int($page) && $page > 0 && $page <= $this->maxPages)
		{
			if($this->perPage > 0 )
			{
				$this->currentPage = $page;
				$index             = ($page * $this->perPage) - ($this->perPage);
				$plot              = array();
				$k                 = 0;
				for ($i = $index ; $i < ($index + $this->perPage) && array_key_exists($i, $this->results) ; $i++)
				{ 
					$plot['questions'][$k] = $this->results[$i];
					$k++;
				}
				$plot['links'] = $this->plotLinks();
				return $plot;
			}
		}
		else if(is_int($page) && $page > $this->maxPages)
		{
			$this->currentPage = $this->maxPages;
			$plot['links']     = $this->plotLinks();
			$index             = ($this->maxPages * $this->perPage) - ($this->perPage);
			$plot              = array();
			$k                 = 0;
			for ($i = $index; $i < $this->numberOfResults; $i++)
			{ 
				$plot[$k] = $results[$i];
				$k++;
			}
			return $plot;
		}
		else if($page == 0 || $page < 0)
		{
			return $this->results;
		}
	}

	private function plotLinks()
	{
		$aside   = floor($this->pageRange - 1);
		$link    = "<ul class='paginate list'>";
		$current = $this->currentPage;
		if($current == 1)
		{
			$link .= "<li><a class='paginate link current' href='#'>1</a></li>";
			for ($i = 1; $i <= $aside && $i < $this->maxPages; $i++)
			{ 
				$link .= "<li><a class='paginate link' href='?page=" . ($current+$i) . "'>" . ($current+$i) . "</a></li>";	
			}
		}
		else if($current == $this->maxPages)
		{
			if($this->maxPages - $aside > 0)
			{
				for ($i = 1; $i <= $aside; $i++)
				{
					$link .= "<li><a class='paginate link' href='?page=" . ($this->maxPages - $aside + $i) . "'>" . ($this->maxPages - $aside + $i) . "</a></li>";
				}
			}
			else
			{
				for ($i = ($this->maxPages - 1); $i > 0; $i--)
				{
					$link .= "<li><a class='paginate link' href='?page=" . ($this->maxPages - $i) . "'>" . ($this->maxPages - $i) . "</a></li>"; 
				}
			}
			$link .= "<li><a class='paginate link current' href='?page=" . $this->maxPages . "'>" . $this->maxPages . "</a></li>"; 
		}
		else
		{
			$link .= "<li><a class='paginate link' href='?page=" . $this->previousPage() . "'>" . $this->previousPage() . "</a></li>";
			$link .= "<li><a class='paginate link current' href='?page=" . $current . "'>" . $current . "</a></li>";
			for ($i=1; $i < $aside - 2; $i++)
			{ 
				if($current + $i > $this->maxPages)
				{
					break;
				}
				$link .= "<li><a class='paginate link' href='?page=" . ($current + $i) . "'>" . ($current + $i) . "</a></li>";
			}
		}
		$link .= "</ul>";
		return $link;
	}

	/**
	 * Returns next page number.
	 */
	private function nextPage()
	{
		if($this->currentPage < $this->maxPages)
		{
			return ($this->currentPage + 1);
		}
	}

	/**
	 * Returns previous page number.
	 */
	private function previousPage()
	{
		if($this->currentPage > 1)
		{
			return ($this->currentPage - 1);	
		}
	}



}
?>
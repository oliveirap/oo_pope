<?php 
/**
 * POPE Test Class
 *
 * @category  Control
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/

class Test
{
	protected $name;
	protected $tags;
	protected $difficulty;
	protected $questions;
	protected $description;
	private   $listkey;

	/**
	 * Function that coordinates all others for a new list creation.
	 * This is the only one that shall be evoked
	 * @uses $this->canSetQuestion() & $this->register();
	 * @param $name the Test name
	 * @param $tags the tags
	 * @param $difficulty the difficulty
	 * @param $questions() the questions
	 * @param $description the description
	 * @return array(can =>  bool, msg => Error/Success message)
	 */
	public function trySetTest($name = null, $tags = null, $difficulty = null,  $questions = null, $description = null)
	{
		$canSet = $this->canSetTest($name, $tags, $difficulty, $questions, $description);
		if($canSet['can'])
		{
			$canSet = $this->register();
			return $canSet;
		}
		else
		{
			return $canSet;
		}
	}

	/**
	 * Check if the test is constructed with valid parameters. If so, sets the properties.
	 * @param $name the Test name
	 * @param $tags the tags
	 * @param $questions() the questions
	 * @param $description the description
	 * @return array(can => bool, msg => Error/Success message)
	 */
	private function canSetTest($name = null, $tags = null, $difficulty = null, $questions = null, $description = null)
	{
		if(empty($name) || empty($tags) || empty($difficulty) || empty($questions) || empty($description))
		{
			return array(
					'can' => false,
					'msg' => 'Todos os campos são obrigátorios.'
				);
		}
		else if(!is_array($questions) && !array_filter($questions))
		{
			return array(
					'can' => false,
					'msg' => 'Você não escolheu as questões da lista.'
				);
		}
		else
		{
			$this->name        = escape($name);
			$this->tags        = escape($tags);
			$this->difficulty  = escape($difficulty);
			$this->questions   = implode(",", array_filter($questions));
			$this->description = escape($description);
			$this->listkey     = generateKey();
			return array(
					'can' => true
				);
		}
	}

	/**
	 * Registers the test on the database. This shall be invoked ONLY by $this-> trySetQuestion
	 * @uses Database::
	 * @return array(can => bool, msg => Error/Success message)
	 */
	private function register()
	{
		$isNewPost = isNewPost();
		if($isNewPost)
		{
			$db   = Conectar();
			$data = array(
					'name'        => $this->name,
					'tags'        => $this->tags,
					'difficulty'  => $this->difficulty,
					'questions'   => $this->questions,
					'description' => $this->description,
					'listkey'     => $this->listkey
				);
			$table = DB_PREFIX . 'tests';
			$id    = $db->insert($table, $data);

			if(!!$id)
			{
				return array(
						'can' => true,
						'msg' => 'Lista cadastrada com sucesso.'
					);
			}
			else
			{
				return array(
						'can' => false,
						'msg' => 'Ocorreu um erro. Por favor, tente novamente. Se o problema persistir, contate um administrador.'
					);
			}
		}
		else
		{
			return array(
					'can' => false,
					'msg' => "Não é possível enviar a mesma lista mais de uma vez."
				);
		}
	}

	
	
}
?>
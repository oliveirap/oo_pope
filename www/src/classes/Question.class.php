<?php 
/**
 * POPE Question Class
 *
 * @category  Questions
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/

// 0 - Vai ser chamado pelo watchers.
// 1 - Verificar se a questão recebe os parâmetros necessários.
// 2 - Se receber, cadastrar.

class Question
{
	protected $tags;
	protected $body;
	protected $answers = array();
	protected $correctAnswer;

	/**
	 * Check if the question is constructed with valid parameters.
	 * Sets the properties for the registerQuestion().
	 * @param $tags The tags, $body The body, $answers() The answers array, being $key the option
	 * and $value the text, $correctAnswer the correct option
	 * @return bool(false) if is not set right, calls $this->registerQuestion() elsewise 
	 */
	private function setQuestion($tags = null, $body = null, $answers = null, $correctAnswer = null)
	{
		if(empty($tags) || empty($body) || empty($answer) || empty($correctAnswer))
		{
			return false;
		}
		else if(!is_array($answers) && array_filter($answers))
		{
			$this->tags = $tags;
			$this->body = $body;
			$this->answers = $answers;
			$this->correctAnswer = $correctAnswer;
			$this->registerQuestion();
		}
	}

	/**
	 * Register the question on the database
	 * @uses Database::
	 * @return bool(true) for success, bool(false) elsewise.
	 */
	
	private function registerQuestion()
	{
		
	}
}
?>
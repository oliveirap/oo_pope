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
	protected $answers;
	protected $correctAnswer;

	/**
	 * Check if the question is constructed with valid parameters.
	 * @param $tags The tags, $body The body, $answers() The answers array, being $key the option
	 * and $value the text, $correctAnswer the correct option
	 * @return array() 'can' => bool(true)/bool(false), 'msg' => $msg for trySetQuestion() interpret.
	 */
	private function canSetQuestion($tags = null, $body = null, $answers = null, $correctAnswer = null)
	{
		if(empty($tags) || empty($body) || empty($answers) || empty($correctAnswer))
		{	
			return array(
					'can' => false,
					'msg' => 'Todos os campos são obrigátorios.'
				);
		}
		else if(!is_array($answers) && !array_filter($answers))
		{
			return array(
					'can' => false,
					'msg' => 'Campo de resposta não pode estar em branco.'
				);
		}
		else if(!array_key_exists($correctAnswer, $answers))
		{
			return array(
					'can' => false,
					'msg' => 'Alternativa correta não possui texto'
				);
		}
		else 
		{
			if(file_exists(FILE_PURIFIER_AUTOLOADER))
			{
				require_once(FILE_PURIFIER_AUTOLOADER);
				$config              = HTMLPurifier_Config::createDefault();
				$purifier            = new HTMLPurifier($config);
				$this->tags          = escape($purifier->purify($tags));
				$this->body          = escapeWithTags($purifier->purify($body));
				$this->answers       = escapeWithTags($this->formatAnswers($answers));
				$this->correctAnswer = $correctAnswer;
				return array(
						'can' => true,
					);
			}
			else
			{
				return array(
						'can' => false,
						'msg' => 'O sistema encontrou um erro no Purifier. Por favor, informe este erro ao administrador.'
					);
			}
		}
	}

	/**
	 * This function is the one that should be invoked for the question registration. It will check if
	 * the question can be queryed and does the job. It's like the construct function.
	 * @uses $this->canSetQuestion() & $this->register()
	 * @param $tags The tags, $body The body, $answers() The answers array, being $key the option
	 * and $value the text, $correctAnswer the correct option
	 * @return return the array of the error if it exists, else invokes $this->register();
	 */
	public function trySetQuestion($tags = null, $body = null, $answers = null, $correctAnswer = null)
	{
		$canSet = $this->canSetQuestion($tags, $body, $answers, $correctAnswer);
		if($canSet['can'])
		{
			return $this->register();
		}
		else
		{
			return $canSet;
		}
	}

	/**
	 * Register the question on the database. This shall be invoked ONLY by $this->trySetQuestion. 
	 * @uses Database::
	 * @return bool(true) for success, bool(false) elsewise.
	 */
	private function register()
	{
		$isNewPost = isNewPost();
		if($isNewPost)
		{
			$db = Conectar();
			$data = array(
					"tag"            => $this->tags,
					"body"           => $this->body,
					"answers"        => $this->answers,
					"correct_answer" => $this->correctAnswer
				);
			$id = $db->insert(DB_PREFIX . 'questions', $data);
			if(!!$id)
			{
				return array(
						'can' => true,
						'msg' => 'Questão cadastrada com sucesso.'
					);
			}
			else
			{
				return array(
						'can' => false,
						'msg' => "Erro ao inserir."
					);
			} 
		}
		else if(!$isNewPost)
		{
			$return = array(
					'can' => false,
					'msg' => "Não é possível enviar a mesma questão mais de uma vez."
				);		
			return $return;	
		}
	}

	/**
	 * Formats a answer array to html. The array should be encoded with $this->encodeAnswer() first.
	 * @return formated html
	 */	
	public function formatAnswers($answers)
	{
		if(is_array($answers) && array_filter($answers))
		{
			$encoded = "";
			foreach($answers as $key => $value)
			{
				$encoded .= "<label class='answer-label'><input type='radio' value='" . $key . "'";
				$encoded .=  " class='answer-radio' name='answer'>" . $value . "</label>";
			}
			return $encoded;
		}
	}

	/**
	 * Formats the answer array. $Key = alt-$, $value = the text.
	 * @param $altText unformatted array
	 * @return formated array
	 */
	public function encodeAnswer($altText)
	{
		$altText = array_filter($altText);
		if(is_array($altText) && array_filter($altText))
		{
			$encoded = array();
			foreach ($altText as $key => $value)
			{
				$key           = "alt-" . ($key+1);
				$encoded[$key] = $value;	
			}
			escape($encoded);
			return $encoded;
		}
		else
		{
			return false;
		}
	}
}
?>
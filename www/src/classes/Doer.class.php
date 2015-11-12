<?php
	/**
	 * POPE DOER Class
	 *
	 * THIS IS THE MASTER CLASS.
	 * THE CLASS OF HEROS
	 * THE CLASS OF WINNERS
	 * THE CLASS FOR GOOD STUDENTS THAT DO STUDIES
	 * FOR THERE IS NO BETTER WAY TO BE THAN BEING A DOER
	 * BE A DOER RIGHT NOW!!!!!!! GO AND TAKE A TASK, ANSWER QUESTIONS AND ACHIEVE GLORY, HONOR, POWER.
	 *
	 * "DON'T LET YOUR DREAMS BE DREAMS. JUST DO IT!" - Shia LaBeouf.
	 *
	 * @category  WINNERS CLASSES
	 * @package   POPE - Plataform For Online Problems and Exercises
	 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
	 * @copyright Copyright (c) 2015
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @version   1.0.0
	 **/
	class Doer
	{
		/** THE DOER SHALL IDENTIFY HIMSELF **/
		protected $theDoer    = null;
		/** EVERY DOER IS A WINNER, UNLESS HE QUITS THE TASK BEFORE IT IS DONE! **/
		protected $isWinner   = true;
		/** ONE SHALL PASS THROUGHT NUMEROUS TESTS, AND ON EACH ON HE OUGHT TO ACHIEVE RIGHTNESS **/
		protected $hasHonor   = false;
		/** THE MORE TESTS ONE TAKES AND SUCCEEDS, MORE HONOR LEVELS HE WILL ACHIEVE. **/
		protected $honorLevel = 0;
		/** EVERY DOER SHALL HAVE A TASK TO TAKE **/
		protected $theTask = array();
		/** EVERY TASK HAS ITS OBJECTIVES **/
		protected $theObjectives = array();
		/** AND THE OBJECTIVES ACHIEVED SHALL BE REGISTRED **/
		protected $completedObjectives = array();

		/**
		 * A DOER KNOW HIS TASK SINCE THE START!!!
		 * @param $tid THE DOER TASK ID
		 * @param $qid THE DOER CURRENT QUESTION
		 * @return array('can' => bool, 'msg' => 'Any msg')
		 */
		public function __construct($doerkey = null, $tid = null, $qid = 1)
		{
			$isDoer = Look::userkeyExists($doerkey); 
			if($isDoer)
			{
				$this->theDoer = $doerkey;
				$accepted      = $this->acceptTheTask($tid); 
				$isAObjective  = $this->isAObjective(null, $qid);
				if($accepted['can'] && $isAObjective['can'])
				{
					print_r(json_encode($this));
					$_SESSION['theDoer'] = json_encode($this);
					return array(
							'can' => true
						);
				}
				else if(!$accepted['can'])
				{
					return $accepted;
				}
				else
				{
					return $isAObjective;
				}
			}
			else
			{
				return array(
						'can' => false,
						'msg' => 'Usuário inválido'
					);
			}
		}

		/**
		 * Sets $this->theTask
		 * @uses Retriever::retrieveTest
		 * @param $tid The testkey to be set
		 * @return array('can' => bool, 'msg' => 'Any msg')
		 */
		private function acceptTheTask($tid)
		{
			$retriever = new Retriever();
			$task = $retriever->retrieveTest(null, null, $tid);
			if(array_filter($task))
			{
				$task = $task[0];
				$this->theTask = $task; 
				$this->theObjectives = explode(",", $task['questions']);
				foreach ($this->theObjectives as $key => $value)
				{
					$this->completedObjectives[$value] = array(
							'completed' => false,
							'sequence'  => '',
							'time'      => ''
						);
				}
				return array(
						'can' => true,
						'msg' => 'Task accepted.'
					);
			}
			else 
			{
				return array(
						'can' => false,
						'msg' => 'Ocorreu um erro.'
					);
			}
		}

		/**
		 * Sees if the question exists on the test.
		 * @param $tid The test to look into, can be null if $this->theTask is set;
		 * @param $qid The question to check
		 * @return array('can' => bool, 'msg' => 'Any msg')
		 */
		private function isAObjective($tid = null, $qid = 1)
		{
			if(!empty($this->theTask) && $qid < sizeof($this->theObjectives))
			{
				return array(
						'can' => true,
						'msg' => 'The objective exists'
					);
			}
			else if(empty($this->theTask))
			{
				$accepted = $this->acceptTheTask($tid);
				if($accepted['can'])
				{
					$this->isAObjective(null, $qid);
				}
				else
				{
					return $accepted;
				}
			}
			else
			{
				return array(
						'can' => false,
						'msg' => 'This is not a objective'
					);
			}
		}

		/**
		 * Inserts log on pp_logs
		 */
		private function logHonor()
		{
			if($this->hasHonor)
			{
				$log = encodeLog($this->completedObjectives);
				$db = Conectar();
				$data = array(
						'userkey' => $this->theDoer,
						'listkey' => $this->theTask['listkey'],
						'answers' => $log,
						'time'    => '',
						'logged'  => date("Y-m-d H:i:s")
					);
				$db->insert(DB_PREFIX . 'logs', $data);
			}
		}

		/**
		 * Step by Step Task doing
		 * @param $qnumber The number of the question
		 * @param $answer the marked Answer
		 * @return bool(true/false) if user is correct or not
		 */
		public function doTest($qnumber, $answer)
		{
			$qnumber   = $qnumber - 1;
			$qid       = $this->theObjectives[$qnumber];
			$completed = $this->completedObjectives[$qid]['completed']; 
			if(Look::isCorrectAnswer($qid, $answer))
			{
				if(!$completed)
				{
					$this->completedObjectives[$qid]['completed']  = true;
					$this->completedObjectives[$qid]['sequence']  .= "$answer"; 
				}
				return true;
			}
			else
			{
				if(!$completed)
				{
					$this->completedObjectives[$qid]['sequence'] .= "$answer,";
				}
				return false;
			}
		}

		/**
		 * Encodes the object as json
		 * @return the JSON
		 */
		public function toJson()
		{
			return json_encode(array(
					'theDoer'             => $this->theDoer,
					'isWinner'            => $this->isWinner,
					'hasHonor'            => $this->hasHonor,
					'honorLevel'          => $this->honoLevel,
					'theTask'             => $this->theTask,
					'theObjectives'       => $this->theObjectives,
					'completedObjectives' => $this->completedObjectives
				));
		}
		
		
		
	}
?>
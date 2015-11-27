<?php 
/**
 * POPE Usuário Base Class
 *
 * @category  Usuário
 * @package   POPE
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 * 
 * Classe para definir usuário.
 **/

class User
{
	protected $id;
	protected $name;
	protected $email;
	protected $user;
	protected $pass;
	protected $userkey;
	protected $type;
	protected $status;
	protected $ticket;
	private   $msg;

	/** Define atributos ao instânciar a classe **/ 
	public function __construct($name = null, $email = null, $user = null, $pass = null, $type = 1, $status = 1, $ticket = null)
	{
		$this->name    = escape($name);
		$this->email   = escape($email);
		$this->user    = escape($user);
		$this->pass    = $pass;
		$this->userkey = generateKey();
		$this->type    = escape($type);
		$this->status  = escape($status);
		$this->ticket  = escape($ticket);
	}

	// Gets

	/** 
	* Check if can be registred
	* @uses Regex::validate* to validate the format, Look::*Exists to check disponibility
	* @return Array(can => bool, msg => Errors)
	 */
	protected function canRegister(){
		$err = array(
			"name"    => "",
			"email"   => "",
			"user"    => "",
			"pass"    => "",
			"userkey" => "",
			"type"    => "",
			"status"  => "",
			"ticket"  => ""
			);
		
		if(empty($this->name))
		{
			$err["name"] = "Nome não informado"; 
		}
		else if(!Regex::validateName($this->name)){
			$err["name"] = "Formato de nome inválido.";
		}

		if(empty($this->email))
		{
			$err["email"] = "E-mail não informado.";
		}
		else if(!Regex::validateEmail($this->email))
		{
			$err["email"] = "E-mail inválido.";
		}

		if(empty($this->user))
		{
			$err["user"] = "Usuário não informado.";
		}
		else if(!Regex::validateUser($this->user))
		{
			$err["user"] = "Usuário inválido.";
		}
		if(empty($this->pass))
		{
			$err["pass"] = "Senha não informada.";
		}
		else if(!Regex::validatePass($this->pass))
		{
			$err["pass"] = "Senha inválida.";
		}
		else
		{
			$this->pass = encriptPass($this->pass);
		}

		if(empty($this->userkey))
		{
			$this->userkey = generateKey();
		}

		if($this->type < 0 || $this->type > 1)
		{
			$err["type"] = "Nível de usuário inválido.";
		}
		if($this->status < 0 || $this->status > 1)
		{
			$err["status"] = "Status do usuário inválido.";
		}
		if(!Look::checkTicket($this->ticket))
		{
			$err["ticket"] = "Ticket indisponível.";
		}

		if(array_filter($err))
		{
			$msg = "Por favor, atente-se ao seguinte:<br>";
			foreach ($err as $key => $value)
			{
				if(!empty($value))
				{
					$msg .= $value . "<br>";
				}
			}
			return array(
					"can" => false,
					"msg" => $msg
				);
		}
		else
		{
			if(Look::userExists($this->user) || Look::emailExists($this->email))
			{
				return array(
						"can" => false,
						"msg" => "E-mail e/ou usuário já cadastrado(s)."
					); 
			}
			else
			{
				return array(
						"can" => true
					);
			}
		}
	}

	/**
	* Returns user info. Not in use as of 10-27-2015
	* @param $args[] fields to be returned, else returns all
	* @return User info.
	 */
	public function getInfo($args = null){
		if(!empty($args))
		{
			if(!is_array($args) && isset($this->$args))
			{
				return $this->$args;
			}
			else if(is_array($args))
			{
				$data = array();
				foreach ($args as $key => $value) {
					if(isset($this->$value))
					{
						$data[$value] = $this->$value;
					}					
				}
				return $data;
			}
		}
		else
		{	
			$data = array(
				"id"      => $this->id,
				"name"    => $this->name,
				"email"   => $this->email,
				"user"    => $this->user,
				"userkey" => $this->userkey,
				"type"    => $this->type,
				"status"  => $this->status,
				);
		} 
	}
	// Sets

	/** 
	* Register the user
	* @uses ::canRegister to check if it is possible to register
	* @return array(registered => true, msg => Registrado com sucesso) if success, array(registered => false, msg => Any error msg) elsewise
	 */
	public function register()
	{
		$can = $this->canRegister();
		if(!$can["can"])
		{
			return array(
					"registered" => false,
					"msg" => $can['msg']
				);
		}
		else
		{
			$db = Conectar();
			$db->set_table_prefix(DB_PREFIX);
			$data = array(
				"name"      => $this->name,
				"email"     => $this->email,
				"username"  => $this->user,
				"password"  => $this->pass,
				"userkey"   => $this->userkey,
				"registered" => date("Y-m-d H:i:s"),
				"type"      => $this->type,
				"status"    => $this->status,
				);
			$db->insert(DB_PREFIX . 'users', $data);
			return array(
					"registered" => true,
					"msg"       => "Registrado com sucesso."
				);
		}
	}
}
?>
<?php

/*	Classe para manipulação de sessão. 
*	Criada por Mauricio Rocha em 23/11/2010 com colaboração de Carlos Vinicius
*	
*	Uso básico, Iniciando:
*		$session = new SessionBrowser();
*       $session->setName("nomeMinhaSessao");
*       $session->setData(array("meus dados"));
*	
*	Uso básico, Consultando:
*		$session = new SessionBrowser();
*		if($session->isLive("nomeMinhaSessao"))
*			print_r($session->getData("nomeMinhaSessao"));
*		else
*			echo "A sessão esta encerrada";
*/

// Constantes, para definir padrões

defined('SB_SESSIONNAME') or define('SB_SESSIONNAME', $_SERVER['HTTP_HOST']);
defined('SB_SESSIONNAME_SUFIX') or define('SB_SESSIONNAME_SUFIX', "_data");
defined('SB_SESSIONID') or define('SB_SESSIONID', str_replace('.','_',SB_SESSIONNAME));
defined('SB_LIFETIME') or define('SB_LIFETIME', 3600); // default to browser's closing.

class SessionBrowser {
    
    private $sessionSessionId = SB_SESSIONID;
    private $sessionSessionName = SB_SESSIONNAME;
    private $sessionSessionNameSufix = SB_SESSIONNAME_SUFIX;
    private $sessionLifeTime = SB_LIFETIME;
    const SESSION_ID = SB_SESSIONID;
    const SESSION_NAME = SB_SESSIONNAME;
    const SESSION_NAME_SUFIX = SB_SESSIONNAME_SUFIX;
    const SESSION_LIFE_TIME = SB_LIFETIME;
    
	// construtor utilizado p/ iniciar e definir um nome p/ a sessão
	public function __construct($start=false,$name=SESSION_NAME)
	{
		if($start)
		{
			session_name($name);
			@session_start();
		}
	}
	
	// Inicia a sessão, opcional: atribuir nome e id com o métodos seguintes
    public function start()
	{
        session_id($this->sessionSessionId);
        session_name($this->sessionSessionName);
        session_set_cookie_params($this->sessionLifetime);
        session_start();
        $_SESSION[$this->sessionSessionName]=true;
        return $this->sessionSessionName;    
    }
	
	// Armazenar dados em uma sessão. Opcional: definir nome da sessão
	public function setData($data=null,$name=SESSION_NAME)
	{
		$this->sessionSessionName=$name;
		$this->start();
		$_SESSION[$this->sessionSessionName.$this->sessionSessionNameSufix]=$data;
	}
	
	// Substitui o adiciona dados em uma sessão. Opcional: definir nome da sessão
	public function setNewData($data=null,$name=SESSION_NAME)
	{
		$this->sessionSessionName=$name;
		if(!is_null($data)){
			foreach($data as $k=>$v){
				$_SESSION[$this->sessionSessionName.$this->sessionSessionNameSufix][$k]=$v;
			}
		}
	}
	
	// Pegar os dados da sessão. Opcional: Definir o nome da sessão
	public function getData($name=SESSION_NAME)
	{
		return $_SESSION[$name.$this->sessionSessionNameSufix];
	}
	
	// Verificando se a sessão ainda esta ativa. Opcional: informar o nome da sessão, caso ela possua
    public function isLive($name =SESSION_NAME)
	{
        $live=false;
        session_name($name);
		@session_start();
		if(isset($_SESSION[$name]))
			$live=true;
		else
            $this->end($name);
		
        return $live;
    }
    
	// Definir o nome da sessão
    public function setName($name =SESSION_NAME)
	{
        $this->sessionSessionName = $name;
    }
    
	// Pegar o nome da sessão
    public function getName()
	{
        return $this->sessionSessionName;
    }
	
	// Pegar o nome da sessão mais o sufixo
    public function getFullName()
	{
        return $this->sessionSessionName.$this->sessionSessionNameSufix;
    }

	// Definir o ID da sessão
    public function setID($ID = SESSION_ID)
	{
        $this->sessionSessionId = $ID;
    }
    
	// Pegar o ID da sessão
    public function getID()
	{
        return $this->sessionSessionId;
    }

	// Definir o tempo (vida) da sessão
    public function setTime($time = SESSION_LIFE_TIME)
	{
        $this->sessionLifetime = $time;
    }
    
	// Pegar o tempo (vida) da sessão
    public function getTime()
	{
        return $this->sessionLifetime;
    }
    
	// Encerrar a sessão
    public function end($name =SESSION_NAME)
	{
        session_name($name);
        @session_start();
        @session_destroy();
        return $name;
    }

}
?>
<?php

/*	Classe para manipulação de sessão. 
*	Criada por Mauricio Rocha em 23/11/2010 com colaboração de Carlos Vinicius
*	
*	Versão 2.0 20/06/2011 por Carlos Vinicius
*	
*   This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
*   visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*
*	Uso básico, Iniciando:
*		$session = new SessionBrowser();
*		$session->setName("nomeMinhaSessao");
*		$session->setData(array("meus dados"));
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
defined('SB_SESSIONID') or define('SB_SESSIONID', md5(time()));
defined('SB_LIFETIME') or define('SB_LIFETIME', 0); // default to browser's closing.
defined('SB_PATH') or define('SB_PATH', "/");

class SessionBrowser {
    
    private $sessionSessionId;
    private $sessionSessionName;
    private $sessionSessionNameSufix;
    private $sessionTime;
    private $sessionPath;
    const SESSION_ID = SB_SESSIONID;
    const SESSION_NAME = SB_SESSIONNAME;
    const SESSION_NAME_SUFIX = SB_SESSIONNAME_SUFIX;
    const SESSION_LIFE_TIME = SB_LIFETIME;
    const SESSION_PATH = SB_PATH;
    
	// Define os valores padrões das variáveis
	private function defaultValues()
	{
		$this->sessionSessionId=(is_null($this->sessionSessionId)||empty($this->sessionSessionId))?self::SESSION_ID:$this->sessionSessionId;
		$this->sessionSessionName=(is_null($this->sessionSessionName)||empty($this->sessionSessionName))?self::SESSION_NAME:$this->sessionSessionName;
		$this->sessionSessionNameSufix=(is_null($this->sessionSessionNameSufix)||empty($this->sessionSessionNameSufix))?self::SESSION_NAME_SUFIX:$this->sessionSessionNameSufix;
		$this->sessionTime=(is_null($this->sessionTime)||empty($this->sessionTime))?self::SESSION_LIFE_TIME:$this->sessionTime;
		$this->sessionPath=(is_null($this->sessionPath)||empty($this->sessionPath))?self::SESSION_PATH:$this->sessionPath;
	}
	
	// construtor utilizado p/ iniciar e definir um nome p/ a sessão
	public function __construct($start=false,$name=null)
	{
		$this->defaultValues();
		if($start)
		{
			$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
			session_name($this->sessionSessionName);
			@session_start();
		}
	}
	
	// Renova o cookie da sessão
	public function renewTime($time=null,$name=null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
		$this->sessionTime=is_null($time)?$this->sessionTime:$time;
		
		setcookie($this->sessionSessionName,$_COOKIE[$this->sessionSessionName],(time()+$this->sessionTime),$this->sessionPath);
	}
	
	// Inicia a sessão, opcional: atribuir nome e id com o métodos seguintes
    public function start()
	{
        session_id($this->sessionSessionId);
        session_name($this->sessionSessionName);
        session_set_cookie_params($this->sessionTime,$this->sessionPath);
        session_start();
        $_SESSION[$this->sessionSessionName]=true;
        return $this->sessionSessionName;    
    }
	
	// Armazenar dados em uma sessão. Opcional: definir nome da sessão
	public function setData($data=null,$name=null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
		$this->start();
		$_SESSION[$this->sessionSessionName.$this->sessionSessionNameSufix]=$data;
	}
	
	// Substitui o adiciona dados em uma sessão. Opcional: definir nome da sessão
	public function setNewData($data=null,$name=null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
		if(!is_null($data)){
			if(is_array($data))
			{
				foreach($data as $k=>$v)
					$_SESSION[$this->sessionSessionName.$this->sessionSessionNameSufix][$k]=$v;
			}	
			else
				$_SESSION[$this->sessionSessionName.$this->sessionSessionNameSufix]=$data;
		}
	}
	
	// Pegar os dados da sessão. Opcional: Definir o nome da sessão
	public function getData($name=null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
		return $_SESSION[$this->sessionSessionName.$this->sessionSessionNameSufix];
	}
	
	// Verificando se a sessão ainda esta ativa. Opcional: informar o nome da sessão, caso ela possua
    public function isLive($name =null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
        $live=false;
        session_name($this->sessionSessionName);
		@session_start();
		if(isset($_SESSION[$this->sessionSessionName]))
			$live=true;
		else
            $this->end($this->sessionSessionName);
		
        return $live;
    }
    
	// Definir o nome da sessão
    public function setName($name =null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
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
    public function setID($id =null)
	{
		$this->sessionSessionId=is_null($id)?$this->sessionSessionId:$id;
    }
    
	// Pegar o ID da sessão
    public function getID()
	{
        return $this->sessionSessionId;
    }

	// Definir o tempo (vida) da sessão
    public function setTime($time =null)
	{
		$this->sessionTime=is_null($time)?$this->sessionTime:$time;
    }
    
	// Pegar o tempo (vida) da sessão
    public function getTime()
	{
        return $this->sessionTime;
    }
	
	// Definir o caminho a partir do qual a sessão será valida
    public function setPath($path =null)
	{
		$this->sessionPath=is_null($path)?$this->sessionPath:$path;
    }
    
	// Pegar o caminho a partir do qual a sessão será valida
    public function getPath()
	{
        return $this->sessionPath;
    }
    
	// Encerrar a sessão
    public function end($name =null)
	{
		$this->sessionSessionName=is_null($name)?$this->sessionSessionName:$name;
        session_name($this->sessionSessionName);
        @session_start();
        @session_destroy();
        return $name;
    }

}
?>
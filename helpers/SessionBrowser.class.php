<?php

/*	Classe para manipulação de sessão. 
*	Criada por Mauricio Rocha em 23/11/2010 com colaboração de Carlos Vinicius
*	
*	Uso básico, Iniciando:
*		$session = new SessionBrowser();
*       $session->setDataName("meus dados","nomeMinhaSessao");
*	
*	Uso básico, Consultando:
*		$session = new SessionBrowser();
*		if($session->isLive("nomeMinhaSessao"))
*			print_r($session->getData("nomeMinhaSessao"));
*		else
*			echo "A sessão esta encerrada";
*/

//Constantes, para definir padrões

defined('SB_SESSIONNAME') or define('SB_SESSIONNAME', $_SERVER['HTTP_HOST']);
defined('SB_SESSIONNAME_SUFIX') or define('SB_SESSIONNAME_SUFIX', "_data");
defined('SB_SESSIONID') or define('SB_SESSIONID', str_replace('.','_',SB_SESSIONNAME));
defined('SB_LIFETIME') or define('SB_LIFETIME', 3600); // default to browser's closing.

class SessionBrowser
{
    private $SB_SESSIONID = SB_SESSIONID;
    private $SB_SESSIONNAME = SB_SESSIONNAME;
    private $SB_SESSIONNAME_SUFIX = SB_SESSIONNAME_SUFIX;
    private $sessionLifetime = SB_LIFETIME;
    //private $sessionData = NULL;
       
	//Inicia a sessão, opcional: atribuir nome e id com o métodos seguintes
    public function start()
	{
        session_id($this->SB_SESSIONID);
        session_name($this->SB_SESSIONNAME);
        session_set_cookie_params($this->sessionLifetime);
        session_start();
        $_SESSION[$this->SB_SESSIONNAME]=true;
        return $this->SB_SESSIONNAME;    
    }
	
	//Armazenar dados em uma sessão. Opcional: definir nome da sessão
	public function setData($data=null,$name=SB_SESSIONNAME)
	{
		$this->SB_SESSIONNAME=$name;
		$this->start();
		$_SESSION[$this->SB_SESSIONNAME.$this->SB_SESSIONNAME_SUFIX]=$data;
	}
	
	//Substitui o adiciona dados em uma sessão. Opcional: definir nome da sessão
	public function setNewData($data=null,$name=SB_SESSIONNAME)
	{
		$this->SB_SESSIONNAME=$name;
		if(!is_null($data)){
			foreach($data as $k=>$v){
				$_SESSION[$this->SB_SESSIONNAME.$this->SB_SESSIONNAME_SUFIX][$k]=$v;
			}
		}
	}
	
	//Pegar os dados da sessão. Opcional: Definir o nome da sessão
	public function getData($name=SB_SESSIONNAME)
	{
		return $_SESSION[$name.$this->SB_SESSIONNAME_SUFIX];
	}
	
	//Verificando se a sessão ainda esta ativa. Opcional: informar o nome da sessão, caso ela possua
    public function isLive($name = SB_SESSIONNAME)
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
    public function setName($name = SB_SESSIONNAME)
	{
        $this->SB_SESSIONNAME = $name;
    }
    
	// Pegar o nome da sessão
    public function getName()
	{
        return $this->SB_SESSIONNAME;
    }
	
	// Pegar o nome da sessão mais o sufixo
    public function getFullName()
	{
        return $this->SB_SESSIONNAME.$this->SB_SESSIONNAME_SUFIX;
    }

	// Definir o ID da sessão
    public function setID($ID = SB_SESSIONID)
	{
        $this->SB_SESSIONID = $ID;
    }
    
	// Pegar o ID da sessão
    public function getID()
	{
        return $this->SB_SESSIONID;
    }

	// Definir o tempo (vida) da sessão
    public function setTime($time = SB_LIFETIME)
	{
        $this->sessionLifetime = $time;
    }
    
	// Pegar o tempo (vida) da sessão
    public function getTime()
	{
        return $this->sessionLifetime;
    }
    
	// Encerrar a sessão
    public function end($name = SB_SESSIONNAME)
	{
        session_name($name);
        @session_start();
        @session_destroy();
        return $name;
    }
}

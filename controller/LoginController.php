<?php
/*
* @author Carlos Vinicius <caljp13@gmail.com>
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class LoginController
{
    public function get()
    {
		$this->form();
    }
	
    public function post()
	{
		$this->auth();
    }
	
	private function form()
	{
		$data["render"]='
			<form action="" method="POST">
			<input type="text" name="username" id="" /><br />
			<input type="text" name="password" id="" />
			<input type="submit" value="login" />
			</form>
		';
		Renderer::renderPage($data);
	}

	private function auth()
	{
		$data["render"]="POST DATA";
		
		$rules = array(
			'username' => 'required|string',
			'password' => 'required|string'
		);

		$validation = new Validation();
		
		if($validation->run($rules))
		{
			$data["render"].= "<br />Validado!<br />";
			
			if($_POST["username"]=="admin" && $_POST["password"]=="123")
			{
				// Iniciando a sessão
				$session=new SessionBrowser();
				$session->setData(array("ok","carlos"));
				
				// Consultando os dados da sessão
				$session=new SessionBrowser();
				if($session->isLive())
					print_r($session->getData());
				else
					echo "A sessão esta encerrada";
			}
		}
		else
			echo $validation->display_errors("<div>","</div>");
		
		foreach($_POST as $k=>$v)
			$data["render"].="<br />$k = $v";

		Renderer::renderPage($data);
	}
}
?>
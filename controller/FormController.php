<?php
/*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class FormController
{
    public function get($method=null)
	{
		// Executa quando nenhum parâmetro é passado após o endereço fixo da rota
		if(is_null($method))
			$this->index();
		else
			$this->$method();
    }
	
    public function post($method=null)
	{
		$this->$method(true);
    }
	
	private function index()
	{
		$data["render"]='
			<form action="'.SITE_URL.'form/send" method="POST">
			<input type="text" name="name" id="" /><br />
			<input type="text" name="email" id="" />
			<input type="submit" value="enviar" />
			</form>
		';
		Renderer::renderPage($data);
	}

	private function send($isPost=false)
	{
		// Dados enviados via POST
		if($isPost)
		{
			$data["render"]="POST DATA";
			
			$rules = array(
				'name' => 'required|string|max_length[50]',
				'email' => 'required|string|min_length[6]'
			);

			$validation = new Validation();
			
			if($validation->run($rules))
				$data["render"].= '<h1>Success!</h1>';
			else
				echo $validation->display_errors("<div>","</div>");
			
			foreach($_POST as $k=>$v)
				$data["render"].="<br />$k = $v";
		}
		// Nenhum dado foi enviado via POST
		else
			$data["render"]="Nenhum formulário POST enviado";
		
		Renderer::renderPage($data);
	}
}
?>

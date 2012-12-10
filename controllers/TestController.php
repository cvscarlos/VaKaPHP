<?php
/*
* @author Carlos Vinicius <caljp13@gmail.com>
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class TestController
{
    public function get($method=null, $parameter=null)
	{
		// Executa quando nenhum parâmetro é passado após o endereço fixo da rota
		if(is_null($method))
			$this->index();

		// Executa quando dois parâmetros (o 1o deve ser um método existente) são passados após o endereço fixo da rota
		elseif(method_exists($this,$method))
			$this->$method($parameter);
		
		// Executa quando apenas um parâmetro é informado e não existe nenhum método que o nome corresponda.
		else
			$this->test($method);
    }

	private function index()
	{
		$data["render"]="Test Index";
		Renderer::renderPage($data);
	}

	private function name($parameter)
	{
		$data["render"]=sprintf("Test Name: %s",$parameter);
		Renderer::renderPage($data);
	}
	
	private function test($parameter)
	{
		$data["render"]=sprintf("Test: %s",$parameter);
		Renderer::renderPage($data);
	}
}
?>
<?php
/*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class CompressController
{
    public function get()
	{
		$renderer=new Renderer;
		
		$renderer->setJs(array("js/smtest.js","js/jquery-1.4.2.js","js/jquery-ui-1.8.1.min.js"));
		$renderer->setCss(array("css/exemple.css"));
		$renderer->setCssCode("/* CSS ADDED */");
		$renderer->setJsCode(
			"$(document).ready(function() {
				$('button').button().click(btn_click);
			});"
		);
		
		$data["render"]=$renderer->getContent("compress");
		
		$renderer->renderPage($data);
    }
}
?>

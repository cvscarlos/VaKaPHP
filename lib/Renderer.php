<?php
/*
* VakaPHP Framework
* @author Carlos Vinicius <caljp13@gmail.com>
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/


class Renderer
{
	static public function renderPage($data="", $page="page")
	{
		include_once(SITE_PATH."view/".$page.".php");
	}
	
	static public function getContent($page, $data="")
	{
		ob_start();
		include_once(SITE_PATH."view/".$page.".php");
		return ob_get_clean();
	}
}
?>
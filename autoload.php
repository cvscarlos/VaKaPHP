<?php
/*
* @author Carlos Vinicius <caljp13@gmail.com>
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class Autoload
{
	static public function controllers($className)
	{
		if(!file_exists(SITE_PATH."controllers/".$className.".php"))
			return false;
		include_once SITE_PATH."controllers/".$className.".php";
	}
	
	static public function classes($className)
	{
		if(!file_exists(SITE_PATH."helpers/".$className.".class.php"))
			return false;
		include_once SITE_PATH."helpers/".$className.".class.php";
	}
	
	static public function helpers($className)
	{
		if(!file_exists(SITE_PATH."helpers/".$className.".php"))
			return false;
		include_once SITE_PATH."helpers/".$className.".php";
	}
	
	static public function lib($className)
	{
		if(!file_exists(SITE_PATH."lib/".$className.".php"))
			return false;
		include_once SITE_PATH."lib/".$className.".php";
	}
}

spl_autoload_register(array('Autoload', 'controllers'));
spl_autoload_register(array('Autoload', 'classes'));
spl_autoload_register(array('Autoload', 'helpers'));
spl_autoload_register(array('Autoload', 'lib'));
?>
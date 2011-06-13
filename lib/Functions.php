<?php
/*
* VakaPHP Framework
* @author Carlos Vinicius <caljp13@gmail.com>
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class Functions extends MicroMvcFunctions
{
	public static function messages($name)
	{
		include_once (SITE_PATH."messages.php");
		return $msg[$name];
	}
}


/*
* @package		MicroMVC
* @author		David Pennington
* @copyright	(c) 2010 MicroMVC Framework
* @license		http://micromvc.com/license
*/
class MicroMvcFunctions
{
	/*
	* Safely fetch a $_POST value, defaulting to the value provided if the key is
	* not found.
	*
	* @param string $k the key name
	* @param mixed $d the default value if key is not found
	* @param boolean $s true to require string type
	* @return mixed
	*/
	public static function post($k, $d = NULL, $s = FALSE)
	{
		if(isset($_POST[$k]))return$s?str($_POST[$k],$d):$_POST[$k];return$d;
	}
	
	/**
	* Type cast the given variable into a string - on fail return default.
	*
	* @param mixed $string the value to convert
	* @param string $default the default value to assign
	* @return string
	*/
	public static function str($str, $default = '')
	{
		return(is_scalar($str)?(string)$str:$default);
	}
}
?>
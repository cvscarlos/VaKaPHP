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
		return @$msg[$name];
	}
	
	public static function redirectTo($url=""){
		if((strpos($url, "http://")!==false) || (strpos($url, "https://")!==false) || (strpos($url, "ftp://")!==false))
			header("Location: ".$url);
		else
			header("Location: ".SITE_URL.$url);
	}
	
	public static function replaceChars($str="")
	{
		$list=array(
			"ç"=>"c",
			"æ"=>"ae",
			"œ"=>"oe",
			"á"=>"a",
			"é"=>"e",
			"í"=>"i",
			"ó"=>"o",
			"ú"=>"u",
			"à"=>"a",
			"è"=>"e",
			"ì"=>"i",
			"ò"=>"o",
			"ù"=>"u",
			"ä"=>"a",
			"ë"=>"e",
			"ï"=>"i",
			"ö"=>"o",
			"ü"=>"u",
			"ÿ"=>"y",
			"â"=>"a",
			"ê"=>"e",
			"î"=>"i",
			"ô"=>"o",
			"û"=>"u",
			"å"=>"a",
			"ã"=>"a",
			"ø"=>"o",
			"Á"=>"A",
			"É"=>"E",
			"Í"=>"I",
			"Ó"=>"O",
			"Û"=>"U",
			"Ú"=>"U",
			"Ù"=>"U",
			"Ê"=>"E",
			"Ô"=>"O",
			"Ü"=>"U",
			"Ã"=>"A",
			"Õ"=>"O",
			"À"=>"A",
			"Ç"=>"C",
			" "=>"_",
			"%"=>"por100",
			"\\"=>"_",
			"/"=>"_",
			"-"=>"_",
			"("=>"_",
			")"=>"_",
			":"=>"_",
			"?"=>"_",
			"!"=>"_",
			"º"=>"_",
			"ª"=>"_"
		);
		return str_replace(array_keys($list),array_values($list),$str);
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
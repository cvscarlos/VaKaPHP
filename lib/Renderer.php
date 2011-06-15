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
	private static $scripts=array();
	private static $styles=array();
	private static $code="";
	private static $cssCode="";
	
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
	
	static public function setCss($styles)
	{
		self::$styles=$styles;
	}
	
	static public function setCssCode($cssCode)
	{
		self::$cssCode=$cssCode;
	}
	
	static public function setJs($scripts)
	{
		self::$scripts=$scripts;
	}
	
	static public function setJsCode($code)
	{
		self::$code=$code;
	}
	
	static public function printCss()
	{
		foreach(self::$styles as $css)
			echo "<link rel='stylesheet' href='".URL_PUBLIC_FOLDER.$css."' />";
	}
	
	static public function printJs()
	{
		foreach(self::$scripts as $js)
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER.$js."'></script>";
	}
	
	static public function printCompressedCss()
	{
		$cacheDir=PUBLIC_PATH."compressed_cache";
		$fileName=str_replace(array("\\","/"),"_",implode(",",self::$styles));
		$cssCode="";
		
		if(!is_writable($cacheDir))
		{
			echo "<!-- The directory (compressed_cache) not writable. O Diretório (compressed_cache) não possui permissão de escrita. -->";
			return self::printCss();
		}
		
		if(file_exists($cacheDir."/".$fileName))
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."'></script>";
		else
		{
			foreach(self::$styles as $js)
				$cssCode.=file_get_contents(PUBLIC_PATH.$js)."\n\n";
				
			$cssc = new CSSCompression($cssCode);
			file_put_contents($cacheDir."/".$fileName,$cssc->css);
			
			echo "<link rel='stylesheet' href='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."' />";
		}
	}
	
	static public function printCompressedJs()
	{
		$cacheDir=PUBLIC_PATH."compressed_cache";
		$fileName=str_replace(array("\\","/"),"_",implode(",",self::$scripts));
		$jsCode="";
		
		if(!is_writable($cacheDir))
		{
			echo "<!-- The directory (compressed_cache) not writable. O Diretório (compressed_cache) não possui permissão de escrita. -->";
			return self::printJs();
		}
		
		if(file_exists($cacheDir."/".$fileName))
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."'></script>";
		else
		{
			foreach(self::$scripts as $js)
				$jsCode.=file_get_contents(PUBLIC_PATH.$js)."\n\n";
				
			$packer = new JavaScriptPacker($jsCode);
			file_put_contents($cacheDir."/".$fileName,$packer->pack());
			
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."'></script>";
		}
	}
	
	static public function printJsCode()
	{
		if(!empty(self::$code))
			echo "<script type='text/javascript'>\n".self::$code."\n</script>";
	}
	
	static public function printCssCode()
	{
		if(!empty(self::$cssCode))
			echo "<style type='text/css'>\n".self::$cssCode."\n</style>";
	}
}
?>
<?php
/*
* VakaPHP Framework
*
* @version 2.0
* @date 2012-01-11
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
	
	/*
	* @method renderPage
	*/
	static public function renderPage($data="", $page="page")
	{
		include_once(SITE_PATH."view/".$page.".php");
	}
	
	/*
	* @method getContent
	*/
	static public function getContent($page, $data="")
	{
		ob_start();
		include_once(SITE_PATH."view/".$page.".php");
		return ob_get_clean();
	}
	
	/*
	* @method mergeDefaultCss
	*/
	static private function mergeDefaultCss()
	{
		global $default;
		if(isset($default)&&array_key_exists("css",$default)&&is_array($default["css"]))
			self::$styles=array_merge($default["css"],self::$styles);
		self::$styles=array_unique(self::$styles);
	}
	
	/*
	* @method mergeDefaultJs
	*/
	static private function mergeDefaultJs()
	{
		global $default;
		if(isset($default)&&array_key_exists("js",$default)&&is_array($default["js"]))
			self::$scripts=array_merge($default["js"],self::$scripts);
		self::$scripts=array_unique(self::$scripts);
	}
	
	/*
	* @method setCss
	*/
	static public function setCss($styles)
	{
		self::$styles=$styles;
	}
	
	/*
	* @method setCssCode
	*/
	static public function setCssCode($cssCode)
	{
		self::$cssCode=$cssCode;
	}
	
	/*
	* @method setJs
	*/
	static public function setJs($scripts)
	{
		self::$scripts=$scripts;
	}
	
	/*
	* @method setJsCode
	*/
	static public function setJsCode($code)
	{
		self::$code=$code;
	}
	
	/*
	* @method printCss
	*/
	static public function printCss()
	{
		self::mergeDefaultCss();
		
		foreach(self::$styles as $css)
			echo "<link rel='stylesheet' href='".URL_PUBLIC_FOLDER.$css."' type='text/css' />";
	}
	
	/*
	* @method printJs
	*/
	static public function printJs()
	{
		self::mergeDefaultJs();

		foreach(self::$scripts as $js)
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER.$js."'></script>";
	}
	
	/*
	* @method printCompressedCss
	*/
	static public function printCompressedCss()
	{
		self::mergeDefaultCss();
		$cacheDir=PUBLIC_PATH."compressed_cache";
		$fileName=md5(str_replace(array("\\","/"),"_",implode(",",self::$styles))).".css";
		$cssCode="";
		
		if(!is_writable($cacheDir))
		{
			echo "<!-- The directory (compressed_cache) not writable. O Diretório (compressed_cache) não possui permissão de escrita. -->";
			return self::printCss();
		}
		
		if(empty($fileName)) return;
		
		if(file_exists($cacheDir."/".$fileName))
			echo "<link rel='stylesheet' href='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."' type='text/css' />";
		else
		{
			foreach(self::$styles as $css)
			{
				if(file_exists(PUBLIC_PATH.$css))
					$cssCode.=file_get_contents(PUBLIC_PATH.$css)."\n\n";
				else
				{
					echo "<!-- file not found: $css | Arquivo não encontrado: $css -->\n";
					$cssCode.="";
				}
			}
			
			if(empty($cssCode)) return;
			
			$cssc = new CSSCompression($cssCode,array("border-radius-combine"=>false));
			file_put_contents($cacheDir."/".$fileName,$cssc->css);
			
			echo "<link rel='stylesheet' href='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."' type='text/css' />";
		}
	}
	
	/*
	* @method printCompressedJs
	*/
	static public function printCompressedJs($compressor="")
	{
		self::mergeDefaultJs();
		$cacheDir=PUBLIC_PATH."compressed_cache";
		$fileName=md5(str_replace(array("\\","/"),"_",implode(",",self::$scripts))).".js";
		$jsCode="";
		
		if(!is_writable($cacheDir))
		{
			echo "<!-- The directory (compressed_cache) not writable. O Diretório (compressed_cache) não possui permissão de escrita. -->";
			return self::printJs();
		}
		
		if(empty($fileName)) return;
		
		if(file_exists($cacheDir."/".$fileName))
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."'></script>";
		else
		{
			foreach(self::$scripts as $js)
			{
				if(file_exists(PUBLIC_PATH.$js))
					$jsCode.=file_get_contents(PUBLIC_PATH.$js)."\n\n";
				else
				{
					echo "<!-- file not found: $js | Arquivo não encontrado: $js -->\n";
					$jsCode.="";
				}
			}
			
			if(empty($jsCode)) return;
			
            if($compressor=="google_compressor")
                self::googleCompressJs($cacheDir,$jsCode,$fileName);
            else
            {
                $packer = new JavaScriptPacker($jsCode);
                file_put_contents($cacheDir."/".$fileName,$packer->pack());
            }
			
			echo "<script type='text/javascript' src='".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."'></script>";
		}
	}
	
	/*
	* @method googleCompressJs
	*/
	static private function googleCompressJs($cacheDir,$jsCode,$fileName)
	{
        if(!function_exists('curl_init'))
        {
            $packer = new JavaScriptPacker($jsCode);
            file_put_contents($cacheDir."/".$fileName,$packer->pack());
        }
        else
        {
            file_put_contents($cacheDir."/".$fileName,$jsCode);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://closure-compiler.appspot.com/compile");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "code_url=".URL_PUBLIC_FOLDER."compressed_cache/".urlencode($fileName)."&compilation_level=SIMPLE_OPTIMIZATIONS&output_format=text&output_info=compiled_code");
            $output = curl_exec($ch);
            curl_close($ch);
            
            file_put_contents($cacheDir."/".$fileName,$output);
        }
	}
    
	/*
	* @method printJsCode
	*/
	static public function printJsCode()
	{
		if(!empty(self::$code))
			echo "<script type='text/javascript'>\n".self::$code."\n</script>";
	}
	
	/*
	* @method printCssCode
	*/
	static public function printCssCode()
	{
		if(!empty(self::$cssCode))
			echo "<style type='text/css'>\n".self::$cssCode."\n</style>";
	}
}

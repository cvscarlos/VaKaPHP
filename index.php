<?php
/*
* VakaPHP Framework < http://github.com/caljp13/VakaPHP >
* @author Carlos Vinicius <caljp13@gmail.com>
*
* @version 2.0
* @date 2012-01-02
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/


// Constants required
// Constantes obrigatórias
// defined("ENVIRONMENT") or define("ENVIRONMENT", getenv('ENVIRONMENT')); // Edit the htaccess to change the mode for production // Edite o .htaccess para alterar o modo para produção
defined("SITE_PATH") or define("SITE_PATH", dirname(__FILE__)."/");
defined("SITE_URL") or define("SITE_URL", strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].preg_replace("/index\.php(.*)/","",$_SERVER['SCRIPT_NAME']));
defined("PUBLIC_PATH") or define("PUBLIC_PATH", SITE_PATH."public/");
defined("URL_PUBLIC_FOLDER") or define("URL_PUBLIC_FOLDER", SITE_URL."public/");


// Array with the files that will be loaded even without being defined in the controller.
// Array com os arquivos que vão ser carregados mesmo sem serem definidos no controller
$default["js"]=array("js/exemple.autoload.js");
$default["css"]=array("css/reset.css","css/exemple.autoload.css");


// Components of the framework
// Componentes do framework
require_once SITE_PATH.'autoload.php';


// Identificação do navegador
// browser identification
$info=array("browserObj"=>new Browser());
$info["browser"]=$info["browserObj"]->getBrowser();
$info["bVersion"]=$info["browserObj"]->getVersion();
$info["browserCss"]=strtolower(str_ireplace(array("internet explorer"," "),array("ie","_"),$info["browser"]));
$info["browserVersionCss"]=strtolower(str_ireplace(array("internet explorer"," "),array("ie","_"),$info["browser"].preg_replace("/\..*/","",$info["bVersion"])));


// Components of the framework
// Componentes do framework
require_once SITE_PATH.'lib/Toro.php';
require_once SITE_PATH.'routes.php';


// Página de erro 404
ToroHook::add("404", function() {
	header('HTTP/1.0 404 Not Found');
	Renderer::renderPage(null,"error404");
});


// Executando o núcleo o framework
Toro::Serve($routes);
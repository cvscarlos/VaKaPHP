<?php
defined("ENVIRONMENT") or define("ENVIRONMENT", getenv('ENVIRONMENT'));
if(!ENVIRONMENT) defined("SITE_PATH") or define("SITE_PATH", dirname(__FILE__)."/");
elseif(ENVIRONMENT=="dev") defined("SITE_PATH") or define("SITE_PATH", dirname(__FILE__)."/");
defined("SITE_URL") or define("SITE_URL", strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].str_replace($_SERVER['PATH_INFO'],"/",$_SERVER['REQUEST_URI']));
defined("PUBLIC_PATH") or define("PUBLIC_PATH", SITE_PATH."public/");
defined("URL_PUBLIC_FOLDER") or define("URL_PUBLIC_FOLDER", SITE_URL."public/");


require_once SITE_PATH.'autoload.php';

$info=array("browserObj"=>new Browser());
$info["browser"]=$info["browserObj"]->getBrowser();
$info["bVersion"]=$info["browserObj"]->getVersion();
$info["browserCss"]=strtolower(str_ireplace(array("internet explorer"," "),array("ie","_"),$info["browser"]));
$info["browserVersionCss"]=strtolower(str_ireplace(array("internet explorer"," "),array("ie","_"),$info["browser"].preg_replace("/\..*/","",$info["bVersion"])));

require_once SITE_PATH.'lib/toro.php';
require_once SITE_PATH.'routers.php';

$routes->serve();
?>
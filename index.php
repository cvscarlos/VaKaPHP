<?php
defined("ENVIRONMENT") or define("ENVIRONMENT", getenv('ENVIRONMENT'));

if(!ENVIRONMENT)
	defined("SITE_PATH") or define("SITE_PATH", dirname(__FILE__)."/");
elseif(ENVIRONMENT=="dev")
	defined("SITE_PATH") or define("SITE_PATH", dirname(__FILE__)."/");

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
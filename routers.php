<?php
$routes = new ToroApplication(array(

    array('/', 'MainController'),
    array("test", 'TestController'),
    array("test/([a-zA-Z0-9_]+)", 'TestController'),
    array("test/([a-zA-Z0-9_]+)/([a-zA-Z0-9_]+)", 'TestController')
	
));
?>
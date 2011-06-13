<?php
$routes = new ToroApplication(array(

    array('/', 'MainController'),
    array("form/", 'FormController'),
    array("form/([a-zA-Z0-9_]+)", 'FormController'), // send
    array("test/", 'TestController'),
    array("test/([a-zA-Z0-9_]+)", 'TestController'),
    array("test/([a-zA-Z0-9_]+)/([a-zA-Z0-9_]+)", 'TestController')
	
));
?>
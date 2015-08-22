<?php
$routes = array(

    "/"=>"MainController",
    "compress"=>"CompressController",
    "form"=>"FormController",
    "form/([a-zA-Z0-9_]+)"=>"FormController",
    "test/"=>"TestController",
    "login"=>"LoginController",
    "test/([a-zA-Z0-9_]+)"=>"TestController",
    "test/([a-zA-Z0-9_]+)/([a-zA-Z0-9_]+)"=>"TestController"
	
);
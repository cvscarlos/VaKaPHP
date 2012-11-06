<?php
/*
* VakaPHP Framework
* @author Carlos Vinicius <caljp13@gmail.com>
*
* @version 2.0
* @date 2012-01-11
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/


class Debug
{
	function __construct($str)
	{
		if(!is_null($str))
		{
			file_put_contents(SITE_PATH."log.txt","---------------------------------------------------------------------\n".date("d-m-Y H:i:s.u")."\n",FILE_APPEND);
			file_put_contents(SITE_PATH."log.txt",$str,FILE_APPEND);
			file_put_contents(SITE_PATH."log.txt","\n",FILE_APPEND);
		}
	}
}
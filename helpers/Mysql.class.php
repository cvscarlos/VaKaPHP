<?php
/*
* @author Carlos Vinicius <caljp13@gmail.com>
*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/

class Mysql{

	const DB_SERVER="localhost";
	const DB_USERNAME="root";
	const DB_PASSWORD="";
	const DB_SCHEMA="mysql";
	
	public function query($query="")
	{
		if(empty($query)) return "Query is empty!";
		
		$mysqli = new mysqli(self::DB_SERVER, self::DB_USERNAME, self::DB_PASSWORD, self::DB_SCHEMA);

		if(mysqli_connect_errno())
			return sprintf("Connect failed: %s\n", mysqli_connect_error());

		$isInsert=false;
		$tmp=explode(" ",trim($query));
		if(strtolower($tmp[0])=="insert")
			$isInsert=true;
			
		$result = $mysqli->query($query);
		if(is_object($result)&&!$isInsert){
			while ($r=$result->fetch_array(MYSQLI_BOTH))
			{
				$row[]=$r;
			}
			$result->close();
		}
		elseif($isInsert)
			$row=mysqli_insert_id($mysqli);
		else
			$row=$result;

		$mysqli->close();

		if(is_object($result)||$isInsert)
			return $row;
	}
	
	public function insert($table, $dataArray)
	{
		$fields=array();
		$values=array();
		foreach($dataArray as $k=>$v)
		{
			$fields[]=$k;
			if(is_null($v))
				$values[]="NULL";
			else
				$values[]="'$v'";
		}
		
		$query=sprintf("INSERT INTO `%s` (`%s`)VALUES (%s);",
			$table,
			implode("`,`",$fields),
			implode(",",$values)
		);
		
		return $this->query($query);
	}
	
	public function update($table, $dataArray, $whereArray)
	{
		$fields=array();
		$restrictions="";
		
		foreach($dataArray as $k=>$v)
		{
			$fields[]="`$k`='$v'";
		}
		
		foreach($whereArray as $v)
		{
			if(is_array($v))
				$restrictions.="`{$v[0]}`='{$v[1]}'";
			else
				$restrictions.=" $v ";
		}

		$query=sprintf("UPDATE `isc_product_search` SET %s WHERE %s",
			implode(", ",$fields));
		
		return $this->query($query);
	}
}
?>
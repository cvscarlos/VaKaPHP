<?php
/*
* This work is licensed under the Creative Commons Attribution 3.0 Unported License. To view a copy of this license,
* visit http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*
* EXAMPLES OF USAGE:
* 
* ## Query:
* 	$mysql = new Mysql();
* 	$result = $mysql->query("SELECT * FROM `user`;");
* 	foreach($result as $v)
* 	{
* 		...
* 	}
* 	$mysql->close();
* 
* ## Insert:
* 	$mysql = new Mysql();
* 	$insertId=$mysql->insert("user",array(
* 		"username"=>$_POST["username"],
* 		"password"=>$_POST["password"]
* 	));
* 	$mysql->close();
* 	echo "Data inserted in id "+$insertId;
* 
* ## Update:
* 	$mysql = new Mysql();
* 	$mysql->update("user",array("password"=>$_POST["newPassword"]),array(array("id"=>1)));
* 	$mysql->close();
* ## or
* 	$mysql = new Mysql();
* 	$mysql->update("user",array("password"=>$_POST["newPassword"]),array(array("id"=>1),"OR",array("username"=>$_POST["username"])));
* 	$mysql->close();
* 
*/

class Mysql
{
	private $conn;
	
	const DB_SERVER="localhost";
	const DB_USERNAME="root";
	const DB_PASSWORD="";
	const DB_SCHEMA="rating";
	
	function __construct()
	{
		$this->conn = new mysqli(self::DB_SERVER, self::DB_USERNAME, self::DB_PASSWORD, self::DB_SCHEMA);

		if ($this->conn->connect_errno)
			return sprintf("Connect failed: %s\n", $this->conn->connect_error);
	}
	
	public function query($query="")
	{
		if(empty($query)) return "Query is empty!";
		$row=null;

		$isInsert=false;
		$tmp=explode(" ",trim($query));
		if(strtolower($tmp[0])=="insert")
			$isInsert=true;
			
		$result = $this->conn->query($query);
		
		if($this->conn->error !="")
			return "#".$this->conn->errno." - ".$this->conn->error;
		
		if(is_object($result)&&!$isInsert){
			while ($r=$result->fetch_array(MYSQLI_BOTH))
			{
				$row[]=$r;
			}
			$result->close();
		}
		elseif($isInsert)
			$row=$this->conn->insert_id;
		else
			$row=$result;

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
		
		$query = $this->conn->query($query);
		
		if(!$query)
			return "#".$this->conn->errno." - ".$this->conn->error;
			
		return $this->conn->insert_id;
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
				$restrictions.="`".key($v)."`='".current($v)."'";
			else
				$restrictions.=" $v ";
		}

		$query=sprintf("UPDATE `%s` SET %s WHERE %s",
			$table,
			implode(", ",$fields),
			empty($restrictions)?1:$restrictions
		);
		
		$query = $this->conn->query($query);
		
		if($this->conn->error !="")
			return "#".$this->conn->errno." - ".$this->conn->error;
			
		return $query;
	}
		
	public function getConnection()
	{
		return $this->conn;
	}

	public function close()
	{
		if(@$this->conn->ping()===true)
			$this->conn->close();
	}
}
?>

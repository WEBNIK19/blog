<?php 

class db {
 
	private static $_instance = NULL;
  
	private function __construct() {	
		$this->mysqli = new mysqli("localhost","root","Nezn@chitnuvse","blog");
		$this->mysqli -> set_charset("utf8");
	}
	
	private function __clone(){}

	public static function getDB(){
		if(is_null(self::$_instance)){
          self::$_instance = new self(); 
		}
			return self::$_instance;
		
	}
	
	

	public function query($sql){
		
		$args = func_get_args();
		$sql = array_shift($args);
		$link = $this->mysqli;
		
		$args = array_map(function ($param) use ($link){
			return $link->escape_string($param);
		},$args);

		$sql = str_replace(array('%','?'),array('%%','%s'),$sql);
    
		array_unshift($args, $sql);

		$sql = call_user_func_array('sprintf',$args);
		//echo $sql;
		$this->last = $this->mysqli->query($sql);
		if($this->last === false) echo 'Database error: '.$this->mysqli->error;

		return $this;
	}

	public function assoc(){
		return $this->last->fetch_assoc();
	}
	public function all(){
		$result = array();
		while($row = $this->last->fetch_assoc()){
			$result[] = $row;
		};
		return $result;
	}
	public function row(){
   return $this->last->fetch_row();
	}
}


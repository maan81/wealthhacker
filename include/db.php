<?php

/**
* Database access & handling
*/
class Database{
	
	private $server;
	private $database;
	private $username;
	private $password;


	function __construct($config=[]){

		$this->server   = $config['server'];
		$this->database = $config['database'];
		$this->username = $config['username'];
		$this->password = $config['password'];
	}
	function connect(){

		$this->con=mysqli_connect($this->server,$this->username,$this->password,$this->database);
		// Check connection
		if (mysqli_connect_errno()){
			$log->lwrite("Failed to connect to MySQL: " . mysqli_connect_error());
			die;
		}
	}
	function disconnect(){

		mysqli_close($this->con);
	}


	/**
	 * Get Table by parameters
	 */
	function get($table,$where_clause=false){
		// _print_r($range_end);
		self::connect();

		$sql = 'SELECT * FROM '.$table.' WHERE 1 ';

		
		if($where_clause){
			$sql .= ' '.$where_clause.' ';
		}

		$sql .= ';';

		// _print_r($sql,false);

		$res = mysqli_query($this->con,$sql);

		$data = array();
		if($res){
		while($val = mysqli_fetch_assoc($res)){
			$data[] = $val;
		}
		}
		self::disconnect();

		return $data;
	}


	function insert($table,$data){

		self::connect();

		$keys = array_keys($data);

		$sql = 'INSERT INTO '.$table.' ( '.implode(',',$keys).' ) VALUES (';

		$first=true;
		foreach($data as $key=>$val){

			if(!$first){
				$sql .= ',';
			}

			$sql .= '"'.$val.'"';

			$first = false;	
		}
		$sql .= ');';
		// _print_r($sql,false);
		mysqli_query($this->con,$sql);

		self::disconnect();
	}


	function update_conversion($table,$data){

		self::connect();

		$keys = array_keys($data);
		$keys[] = 'Count';

		// $sql = ' INSERT INTO '.$table.' ( '.implode(',',$keys).' ) '.
		// 		' VALUES ( "'.implode('", "', $data).'" ); ';

		$sql = 'UPDATE '.$table.' SET '.
					' `Datetime`="'.$data['Datetime'].'", '.
					' `Count`=`Count` + 1 '.
				' WHERE 1 '.
				
				' AND Base="'.$data['Base'].'" '.
				' AND Target="'.$data['Target'].'" '.
				' AND `Amount`='.$data['Amount'].' '.
				
				' ; ';

		// _print_r($sql,false);
		mysqli_query($this->con,$sql);

		self::disconnect();
	}


	function del($table,/*$range*/ $where_clause=false){
		self::connect();

		$sql = 'DELETE FROM '.$table.' WHERE 1 ';

		// $datetime = new DateTime(null, new DateTimeZone('UTC'));
		// $datetime->modify($range);
		// $earlier =  $datetime->format('Y-m-d H:i:s');

		// $sql .= ' AND Datetime 	<= "'.$earlier.'"';

		if($where_clause){
			$sql .= $where_clause;
		}

		$sql .= ';';

		// _print_r($sql,false);

		mysqli_query($this->con,$sql);

		self::disconnect();
	}


	function truncate($table){
		self::connect();

		$sql = 'TRUNCATE TABLE  '.$table.';';

		// _print_r($sql,false);

		mysqli_query($this->con,$sql);

		self::disconnect();
	}

}



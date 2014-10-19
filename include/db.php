<?php

/**
* Database access & handling
*/
class Database{
	
	public $sql;

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
		mysqli_set_charset($this->con, 'utf8');
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

		$this->sql = $sql;

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

		$this->$sql=$sql;

		mysqli_query($this->con,$sql);

		self::disconnect();
	}


	function queries_update_log($table,$symbol,$datetime){

		// chk if existing symbol exists
		$data = $this->get($table,' AND symbol = "'.$symbol.'"');


		// insert
		if(count($data)==0){

			$datetime = new DateTime(null, new DateTimeZone('UTC'));
   
   			$this->insert($table,[ 'symbol'  => $symbol,
   								   'datetime'=> $datetime->format('Y-m-d H:i:s')
								]
						);
   			return;

		}


		self::connect();

		// update
		$sql = 'UPDATE '.$table.' SET '.
					' datetime="'.$datetime.'", '.
					' count=count+1 '.
				' WHERE 1 '.
				
				' AND symbol="'.$symbol.'" '.
				' ; ';

		$this->sql = $sql;

		mysqli_query($this->con,$sql);

		self::disconnect();
	}


	function del($table, $where_clause=false){
		self::connect();

		$sql = 'DELETE FROM '.$table.' WHERE 1 ';

		if($where_clause){
			$sql .= $where_clause;
		}

		$sql .= ';';

		$this->sql = $sql;

		mysqli_query($this->con,$sql);

		self::disconnect();
	}


	function truncate($table){
		self::connect();

		$sql = 'TRUNCATE TABLE  '.$table.';';

		$this->sql = $sql;

		mysqli_query($this->con,$sql);

		self::disconnect();
	}

	function query($sql=false){
		self::connect();

		$this->sql = $sql;

		mysqli_query($this->con,$sql);

		self::disconnect();
	}
}



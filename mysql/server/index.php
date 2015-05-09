<?php
/**
* Allan: Database class for object-oriented database connection. 
* Change $dbname to whatever you have named your schema, in
* my case I re-used the unindexed schema from the first exercise
*/
class Database{
	public function connect(){
		$username = "root";
		$password = "";
		$hostname = "localhost";
		$dbname = "fruitdb";
		
		$this->connection = mysqli_connect($hostname, $username, $password, $dbname);
		
		if(mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}
	
	//encapsulation for any query (if we use mysqli_query everytime we have to specify the connection every time,
	//but we are only using a single connection)
	public function query($query){
		return mysqli_query($this->connection, $query);
	}
	
	//close connection on page close
	public function __destruct(){
		mysqli_close($this->connection);
	}
}

$db = new Database;
$db->connect();

	public function insertFruit($name, $price, $qty, $distributor, $date){
		$id = mysql_insert_id();
		$db->query("INSERT INTO fruit SET id = '$id', name ='$name', price = '$price', qty = '$qty', distributor = '$distributor', date = '$date'") or die(mysql_errno($conn));

			if(!empty($id)) {
				echo $name." successfully added.";
			}
	}

	public function insertFruitPrice($name, $price, $dateUpdated){
		$dateUpdated = date("Y-m-d"); /* SysDate */

		$id = mysql_insert_id();
		$db->query("INSERT INTO fruitprices SET id='$id', name ='$name', price = '$price', dateUpdated = '$dateUpdated'") or die(mysql_errno($conn));

		if(!empty($id)) {
			echo $name." successfully added.";
		}
	}			

	public function viewAll(){
		$db->query("SELECT * FROM FRUIT");
	}

	public function search($input){
		$db->query("SELECT * FROM FRUIT WHERE NAME = '" . $input . "'");
	}	

	public function priceHistory($input){
		$db->query ("SELECT * FROM FRUITPRICE WHERE FRUITID = " . $input);
	}

	public function editFruit(){
		$sql = "UPDATE fruit 
		SET name='".$_POST['name'].
				  "', quantity=".$_POST['quantity'].
				  ", distributor='".$_POST['distributor'].
				  "' WHERE id=".$_POST['id'];


		$result = $db->query($sql);
		echo $result;
	}

	public function editFruitPrice($id){
		$sql = "INSERT INTO fruitprice(fruitId,price) VALUES(".$_POST['id'].", ".$_POST['id'].")";
		$result = $db->query($sql);
		echo $result;
	}
/*
$rows = array();

//fetch all result rows and store them in an array;
while($row = mysqli_fetch_assoc($result)){
	array_push($rows, $row);
}
*/

//encode first to json for easier parsing on the javascript side
//echo json_encode($result);
echo $result;
?>
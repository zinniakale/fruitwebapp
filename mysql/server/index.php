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

if($_GET['yes'] == 1) {
	if($_GET['func'] == 'getData') {
		echo $_GET['query'];
	}
}
else {
switch($_POST['func']) {
	case 'getData':
		$db->getData();
		/*
			should return:
				[{
					id: ,
					name: "",
					price: "00.00",
					quantity: ,
					distributor: "",
					dateAdded: "mm-dd-yyyy",
					priceHistory: [
						{
							id: ,
							price: "00.00",
							dateUpdated: "mm-dd-yyyy"
						},
						{..}, ...]
				}, {..}, ...]
		*/
		echo json_encode($db->data);
		break;
	case 'addData':
		$data = json_decode($_POST['data']);
		$fruitid = $db->addFruit($data->name, $data->price, $data->quantity, $data->distributor, $data->dateAdded);
		$priceid = $db->addFruitPrices($fruitid, $data->priceHistory->price, $data->priceHistory->dateUpdated);
		
		$return = new stdClass();
		$return->fruitid = $fruitid;
		$return->priceid = $priceid;
		/*
			should return:
				{
					fruitid: ,
					priceid: 
				}
		*/
		echo json_encode($return);
		break;
	case 'updateData':
		$data = json_decode($_POST['data']);
		$db->editFruit($data->id, $data->name, $data->price, $data->quantity, $data->distributor, $data->dateAdded);
		if($data->priceChanged) $db->addFruitPrices($data->id, $data->price, $data->dateUpdated);
		echo 1;
		break;
	case 'deleteData':
		$data = json_decode($_POST['data']);
		$db->deleteFruit($data->id);
		$db->deleteFruitPrices($data->priceids);
		echo 1;
}
}
	// public function insertFruit($name, $price, $qty, $distributor, $date){
	// 	$id = mysql_insert_id();
	// 	$db->query("INSERT INTO fruit SET id = '$id', name ='$name', price = '$price', qty = '$qty', distributor = '$distributor', date = '$date'") or die(mysql_errno($conn));

	// 		if(!empty($id)) {
	// 			echo $name." successfully added.";
	// 		}
	// }

	// public function insertFruitPrice($name, $price, $dateUpdated){
	// 	$dateUpdated = date("Y-m-d"); /* SysDate */

	// 	$id = mysql_insert_id();
	// 	$db->query("INSERT INTO fruitprices SET id='$id', name ='$name', price = '$price', dateUpdated = '$dateUpdated'") or die(mysql_errno($conn));

	// 	if(!empty($id)) {
	// 		echo $name." successfully added.";
	// 	}
	// }			

	// public function viewAll(){
	// 	$db->query("SELECT * FROM FRUIT");
	// }

	// public function search($input){
	// 	$db->query("SELECT * FROM FRUIT WHERE NAME = '" . $input . "'");
	// }	

	// public function priceHistory($input){
	// 	$db->query ("SELECT * FROM FRUITPRICE WHERE FRUITID = " . $input);
	// }

	// public function editFruit(){
	// 	$sql = "UPDATE fruit 
	// 	SET name='".$_POST['name'].
	// 			  "', quantity=".$_POST['quantity'].
	// 			  ", distributor='".$_POST['distributor'].
	// 			  "' WHERE id=".$_POST['id'];


	// 	$result = $db->query($sql);
	// 	echo $result;
	// }

	// public function editFruitPrice($id){
	// 	$sql = "INSERT INTO fruitprice(fruitId,price) VALUES(".$_POST['id'].", ".$_POST['id'].")";
	// 	$result = $db->query($sql);
	// 	echo $result;
	// }
/*
$rows = array();

//fetch all result rows and store them in an array;
while($row = mysqli_fetch_assoc($result)){
	array_push($rows, $row);
}
*/

//encode first to json for easier parsing on the javascript side
//echo json_encode($result);
//echo $result;

?>
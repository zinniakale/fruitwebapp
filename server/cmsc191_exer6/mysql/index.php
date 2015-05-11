<?php
header("Access-Control-Allow-Origin: *");

class Database{
	public function connect(){
		$username = "root";
		$password = "";
		$hostname = "localhost";
		$dbname = "fruitdb";
		
		$this->mysqli = mysqli_connect($hostname, $username, $password, $dbname) or die("Error ".mysqli_error($this->mysqli));

	}
	
	//encapsulation for any query (if we use mysqli_query everytime we have to specify the connection every time,
	//but we are only using a single connection)
	protected function query($query){
		$result = $this->mysqli->query($query);
		return $result;
	}

	protected function _getPriceHistory(){
		foreach ($this->data as $key => $value) {
			$id = $value->id;
			$result = $this->query("SELECT * FROM fruitprices WHERE id=$id");
			while($row = $result->fetch_object()) {
				$p = new stdClass();
				$p->id = $row->id;
				$p->price = $row->price.".00";
				$p->dateUpdated = $row->dateUpdated;
				array_push($value->priceHistory, $p);
			}
			$result->free();
		}
	}
	
	//close connection on page close
	public function __destruct(){
		$this->mysqli->close();
	}

	public function getData() {
		$ret = [];
		$result = $this->query("SELECT * FROM fruit");
		while($row = $result->fetch_object()) {
			$r = new stdClass();
			$r->id = $row->id;
			$r->name = $row->name;
			$r->price = $row->price.".00";
			$r->quantity = $row->quantity;
			$r->distributor = $row->distributor;
			$r->dateAdded = $row->dateAdded;
			$r->priceHistory = [];
			array_push($ret, $r);
		}
		$result->free();
		$this->data = $ret;
		$this->_getPriceHistory();
	}

	public function addFruit($name, $price, $qty, $distributor, $dateAdded){
		$stmt = "INSERT INTO fruit(name, price, quantity, distributor, dateAdded) VALUES (\"{$name}\", {$price}, {$qty}, \"{$distributor}\", \"{$dateAdded}\")";
		$this->query($stmt);
		return $this->mysqli->insert_id;
	}

	public function addFruitPrices($id, $price, $dateUpdated){ 
		$stmt = "INSERT INTO fruitprices(fruitid, price, dateUpdated) VALUES (\"{$id}\", \"{$price}\", \"{$dateUpdated}\")";
		$this->query($stmt);
		return $this->mysqli->insert_id;
	}

	public function editFruit($id, $name, $price, $qty, $distributor, $date){
		$stmt = "UPDATE fruit SET name=\"{$name}\", price={$price}, quantity={$qty}, distributor=\"{$distributor}\", dateAdded=\"{$date}\" WHERE id=$id";
		$this->query($stmt);
	}

	public function deleteFruit($id){
		$this->query("DELETE FROM fruit WHERE id=$id");
	}

	public function deleteFruitPrices($priceids){
		foreach ($priceids as $key => $value) {
			$this->query("DELETE FROM fruitprices WHERE id=$value");
		}
	}
}

$db = new Database;
$db->connect();

switch($_POST['func']) {
	case 'getData':
		$db->getData();
		echo json_encode($db->data);
		break;
	case 'addData':
		$data = json_decode($_POST['data']);
		$fruitid = $db->addFruit($data->name, $data->price, $data->quantity, $data->distributor, $data->dateAdded);
		$priceid = $db->addFruitPrices($fruitid, $data->priceHistory->price, $data->priceHistory->dateUpdated);
		
		$return = new stdClass();
		$return->fruitid = $fruitid;
		$return->priceid = $priceid;
		echo json_encode($return);
		break;
	case 'updateData':
		$data = json_decode($_POST['data']);
		$db->editFruit($data->id, $data->name, $data->price, $data->quantity, $data->distributor, $data->dateAdded);
		if($data->priceChanged) {
			$priceid = $db->addFruitPrices($data->id, $data->price, $data->dateUpdated);
			echo json_encode($priceid);
		}
		else echo 1;
		break;
	case 'deleteData':
		$data = json_decode($_POST['data']);
		$db->deleteFruit($data->id);
		$db->deleteFruitPrices($data->priceids);
		echo 1;
}
?>
<?php
	if(count($_POST)>0) {
		$conn = mysql_connect("localhost","root","");
		mysql_select_db("fruit_record",$conn);
		mysql_query("INSERT INTO fruit SET name ='$name', price = '$price', quantity = '$quantity', distributor = '$distributor', date = '$date'") or die(mysql_errno($conn));
		$id = mysql_insert_id();

		if(!empty($id)) {
			echo $name." successfully added.";
		}
	}
?>
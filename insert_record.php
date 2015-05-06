<?php
		$conn = mysql_connect("localhost","root","");

		$date = dateUpdated("Ymd"); /* SysDate/ format: 201504287 */

		// if(table == 'fruit')
			mysql_select_db("fruit_record",$conn);
			$id = mysql_insert_id();
			mysql_query("INSERT INTO fruit SET name ='$name', price = '$price', qty = '$qty', distributor = '$distributor', date = '$date'") or die(mysql_errno($conn));

			if(!empty($id)) {
				echo $name." successfully added.";
			}

		// if(table == 'fruitprices')
			$id = mysql_insert_id();
			mysql_q
			uery("INSERT INTO fruitprices SET name ='$name', price = '$price', dateUpdated = '$dateUpdated'") or die(mysql_errno($conn));

			if(!empty($id)) {
				echo $name." successfully added.";
			}
?>
<!--#!/usr/bin/php -q-->
<?PHP
/**
This PHP script assumes that
[1] you have downloaded the library from https://github.com/dready92/PHP-on-Couch
[2] you have a database named myfruit with the following fields: fruit, price and qty
You can use other existing libraries should ever you want to deviate
references:
https://github.com/dready92/PHP-on-Couch
http://systemsarchitect.net/a-painless-guide-to-apache-couchdb-for-a-php-developer/
http://www.ibm.com/developerworks/library/os-php-couchdb/
https://wiki.apache.org/couchdb/Getting_started_with_PHP
http://www.saggingcouch.com/
http://zinoui.com/blog/headcouch-couchdb-php-client
http://doctrine-couchdb.readthedocs.org/en/latest/reference/introduction.html
*/
### ANON DSN
$couch_dsn = "http://localhost:5984/";
### AUTHENTICATED DSN
### $couch_dsn = "http://user:password@localhost:5984/"
$couch_db = "myfruit";
/**
* include the library
*/
require_once "/lib/couch.php";
require_once "/lib/couchClient.php";
require_once "/lib/couchDocument.php";
$client = new couchClient($couch_dsn, $couch_db);
try {
	$doc = $client->useDatabase('fruit_record');
	$doc = $client->getAllDocs();
} catch (Exception $e) {
	if ( $e->code() == 404 ) {
		echo "Document \"some_doc\" not found\n";
	} else {
		echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	}
	exit(1);
}
	//print_r($doc);
	echo '<table>';
	echo '<tr><td>Fruit</td><td>Price</td><td>Qty</td></tr>';
	$i=0;
	$doc = (array)$doc;
	for($i=0; $i < $doc['total_rows']; $i++){
		$data = (array)$doc['rows'][$i];
		$mydata = (array)$client->getDoc($data['id']);
		$fruit = $mydata['fruit'];
		$price = $mydata['price'];
		$quantity = $mydata['quantity'];
		echo '<tr><td>'.$fruit.'</td><td>'.$price.'</td><td>'.$qty.'</td></tr>';
	}
	echo '</table>';
?>
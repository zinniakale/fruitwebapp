<?php
//smaple connection to mongodb 
//based on our example data
//datase is assumed to be named test and collection is zipcoll
//refer to the following references:
/*
http://php.net/manual/en/mongoclient.construct.php
http://php.net/manual/en/mongo.core.php
http://php.net/manual/en/class.mongocollection.php
http://php.net/manual/en/class.mongodb.php
http://docs.mongodb.org/manual/reference/default-mongodb-port/
rnc recario revised 2015
*/
// Config
$dbhost = 'localhost';
$dbname = 'fruit_record';
 
$db = new MongoClient('mongodb://localhost', array());
$c1 = $db->selectCollection("test", "zipcoll");
$cursor = $c1->find();
foreach ($cursor as $doc) {
    // do something to each document
	$population = $doc['pop'];
	$city = $doc['city'];
	$state = $doc['state'];
	echo 'City: '.$city.' State: '.$state.' Pop: '.$population."<br/>";
}
 
 ?>
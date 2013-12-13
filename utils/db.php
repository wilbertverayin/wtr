<?php

function pr($array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

//CONNECTION UTILITIES
function openConnection(){
	// Create connection
	$con = mysqli_connect("localhost","root","root","wraptoryx");
	// Check connection
	if (mysqli_connect_errno($con)) {
		//echo "Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
		//echo "Connected to db.";
	}
	return $con;
}

//QUERY UTILITIES
function fetchResults($result){
	while($row = mysqli_fetch_assoc($result)){		
	    $array[] = $row; 
	}
	if (empty($array)){
		$array = array();
	}
	return $array;
}

function executeQuery($query) {
	$con = openConnection();	
	$result = mysqli_query($con, $query) or die(mysql_error());	
	mysqli_close($con);
	return $result;
}

//QUERIES
function selectAllInstances() {
	$query = "SELECT id, uid, port, file, name, weights, status  FROM instances";	
	return fetchResults(executeQuery($query));
}

function selectInstanceById($id) {
	$query = "SELECT id, uid, port, file, name, weights, status FROM instances WHERE id = {$id}";	
	return fetchResults(executeQuery($query));
}

function updateInstanceStatusById($id,$status) {
	$query = "UPDATE `instances` SET `status`= '{$status}' WHERE `id` = {$id}";		
	return executeQuery($query);
}

function insertInstance($uid,$port,$filename,$name,$weights) {
	$query = "INSERT INTO `instances`(`uid`, `port`, `file`, `name`, `weights`, `status`) VALUES({$uid},'{$port}','{$filename}','{$name}','{$weights}', 'down')";
	return executeQuery($query);
}

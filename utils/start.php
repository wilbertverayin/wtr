<?php
	include_once "myrrix.php";
	include_once "db.php";
	$instanceId = $_GET['id'];
	$results = selectInstanceById($instanceId);
	$instance = $results[0];
	$port = $instance['port'];
	$file = $instance['file'];
	$weightstring = $instance['weights'];
	$weights = explode(",",$weightstring);
	updateInstanceStatusById($instanceId,"up");
	startInstance($port,$file,$weights);
?>

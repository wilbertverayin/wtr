<?php
include_once"myrrix.php";
?>

<html>
<title>Wraptoryx</title>
<body>
	<h3>Welcome to Wraptoryx</h3>
	
	All instances<br/>
	<?php
	$instances = selectAllInstances();
	foreach ($instances as $instance){
		echo $instance['id'].": ";
		echo $instance['name'].", ";
		echo $instance['port'].", ";
		echo $instance['file'].", ";
		echo $instance['status']." ";
		$startPage = "start.php?id=".$instance['id'];
		echo "<a href=\"{$startPage}\" target=\"_blank\">Click to activate this instance.</a><br/>";
	}
	?>

</body>
</html>


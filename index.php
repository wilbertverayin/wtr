<?php
include "utils/db.php";
?>
<html>
<title>Wraptoryx</title>
<body>
	<h3>Welcome to Wraptoryx</h3>
	Create a new instance
	<form action="utils/upload.php" method="post" enctype="multipart/form-data">		
		<input type="hidden" name="uid" id="uid" value="2"><br/>	
		Name <input type="text" name="name" id="name"><br/>
		Port <input type="text" name="port" id="port"><br/>
		Weights <input type="text" name="weights" id="weights"><br/>
		File <input type="file" name="file" id="file"><br/>	
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>

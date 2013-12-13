<?php
include_once "db.php";

//test();
function test() {

}

function startInstance($port,$data,$weights) {
	processFile($port,$data,$weights);
	createInstance($port,$port);
}

function initConfig(){
	$config = parse_ini_file("config.ini");
	return $config;
}

function createFolder($folderName){
	$config = initConfig();
	$newFolder = "../myrrix/inputs/{$folderName}";
	if (file_exists($newFolder)) {
		rrmdir($newFolder);	
	}
	mkdir($newFolder, 0777, true);
	chmod($newFolder,0777);
}

function rrmdir($dir) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
		foreach ($objects as $object) { 
			if ($object != "." && $object != "..") { 
				if (filetype($dir."/".$object) == "dir") {
					rrmdir($dir."/".$object); 
				} else {
					unlink($dir."/".$object); 
				}
			} 
		} 
		reset($objects); 
		rmdir($dir); 
	} 
}

function findAvailablePort(){
	$host = 'localhost';
	$port = 8000;
	while ($port <= 8080) {
		$connection = @fsockopen($host, $port);
		if (is_resource($connection)) {			
			fclose($connection);
			return $port;
		}
		$port++;
	}
	return 8080;
}

function createInstance($path, $port) {
	$config = initConfig();
	$myrrixPath = $config['project_path']."/myrrix";
	$localInputDir = $myrrixPath."/inputs/{$path}";
	$command = "java -jar {$myrrixPath}/myrrix-serving-1.0.1.jar --localInputDir \"".$localInputDir."\" --port {$port}";
	//exec($command);
}

function findPid($command){
	$output = shell_exec("ps ax | grep \"{$command}\"");
	$arr = explode(" ",$output);
	$pid = $arr[1];
	return $pid;
}

function stopInstanceByProcessId($pid) {
	$other = $pid+1;
	$cmd1 = "echo ubuntu12.04 | sudo -S kill -9 {$pid}";
	$cmd2 = "echo ubuntu12.04 | sudo -S kill -9 {$other}";
	echo $cmd1;
	echo $cmd2;
	$output1 = exec($cmd1);
	$output2 = exec($cmd2);
}

 
function postPreference($userId, $itemId, $host = 'localhost', $port = 8000) {
	$server = "{$host}:{$port}";
	$ch = curl_init();
	$url = $server."/pref/$userId/$itemId";
	//curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36',
	'Content-Type: application/x-www-form-urlencoded',
	'Accept-Encoding: gzip,deflate,sdch',
	'Accept-Language: en-US,en;q=0.8',
	'Content-Length: 0'
	));
	$server_output = curl_exec ($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
}
 
function removePreference($userId, $itemId, $host = 'localhost', $port = 8000) {
	$server = "{$host}:{$port}";
	$ch = curl_init();
	$url = $server."/pref/$userId/$itemId";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36',
	'Content-Type: application/x-www-form-urlencoded',
	'Accept-Encoding: gzip,deflate,sdch',
	'Accept-Language: en-US,en;q=0.8',
	'Content-Length: 0'
	));
	$server_output = curl_exec ($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
}

function resetDev() {
	$files = "../files";
	$inputs = "../myrrix/inputs";
	rrmdir($files);
	rrmdir($inputs);
	mkdir($files, 0777, true);
	mkdir($inputs, 0777, true);
}

function isRunning($pid){
    try{
        $result = shell_exec(sprintf("ps %d", $pid));
        if( count(preg_split("/\n/", $result)) > 2){
            return true;
        }
    }catch(Exception $e){}
    return false;
}

function processFile($port,$data,$weights = array(1)) {
echo "<pre>";
	createFolder($port);
	$input= "../files/{$data}";
	$output = "../myrrix/inputs/{$port}/{$data}";
	$input_file = fopen($input, "r");
	$output_file = fopen($output, 'w+');

	$criteriaNum = sizeof($weights);

	if ($input_file) {
		while (($line = fgets($input_file)) !== false){
			$values = explode(",", $line);
			$userId = $values[0];
			$itemId = $values[1];
			unset($values[0]);
			unset($values[1]);
			$criteria = array_values($values);
			$computedWeight = 0;
			for ($i=0; $i<$criteriaNum; $i++) {
				$multiplier = 1;
				if(isset($weights[$i])){
					$multiplier = $weights[$i];
				}
				$computedWeight += $criteria[$i]*$multiplier;
			}

			echo "{$userId},{$itemId},$computedWeight\n";

			if ($computedWeight>0) {
				fwrite($output_file, "{$userId},{$itemId},$computedWeight\n");
			}
		}
	} else {
	    //echo "error opening the file.";
	}
echo "</pre>";
	fclose($input_file);
	fclose($output_file);
}

function findPidByInstanceId($id){

	$instances = selectInstanceById($id);
	$instance = $instances[0];
	$port = $instance['port'];
	$config = initConfig();
	$myrrixPath = $config['project_path']."/myrrix";
	$localInputDir = $myrrixPath."/inputs/{$port}";
	$command = "java -jar {$myrrixPath}/myrrix-serving-1.0.1.jar --localInputDir \"".$localInputDir."\" --port {$port}";
	return findPid($command);
}

?>

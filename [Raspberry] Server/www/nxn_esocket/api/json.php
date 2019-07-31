<?PHP
// set the header to make sure cache is forced
header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
header('Content-type:application/json;charset=utf-8');

//Main
$data = "";


// Add Nodes to ARRAY
$nodes = array();
$row_array = array(); // Clear Array from prev ADD
$sql = "SELECT name,location,ip,port FROM nodes";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$row_array['name'] = $row['name'];
		$row_array['location'] = $row['location'];
		$row_array['ip'] = $row['ip'];
		$row_array['port'] = $row['port'];
		array_push($nodes,$row_array);
    }
	$data['nodes'] = $nodes;
}
// Add Sockets to ARRAY
$sockets = array();
$row_array = array(); // Clear Array from prev ADD
$sql = "SELECT controlled_device,state,needs_permit,dip_main,dip_second FROM sockets";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$row_array['socket_name'] = $row['controlled_device'];
		$row_array['state'] = $row['state'];
		if($row['needs_permit'] == 1) {
			$row_array['needs_permit'] = 'true';
		}else{
			$row_array['needs_permit'] = 'false';
		}
		$row_array['dip_main'] = $row['dip_main'];
		$row_array['dip_second'] = $row['dip_second'];
		array_push($sockets,$row_array);
    }
	$data['sockets'] = $sockets;
}
// Add Users to ARRAY
$users = array();
$row_array = array(); // Clear Array from prev ADD
$sql = "SELECT username,last_login FROM users";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$row_array['username'] = $row['username'];
		$row_array['last_login'] = $row['last_login'];
		array_push($users,$row_array);
    }
	$data['users'] = $users;
}
// Add Users to ARRAY
$system = array();
$row_array = array(); // Clear Array from prev ADD
$sql = "SELECT company,homepage,developer,versionstring,versionint FROM system LIMIT 1";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$row_array['company'] = $row['company'];
		$row_array['version_humanreadable'] = $row['versionstring'];
		$row_array['version_integer'] = $row['versionint'];
		$row_array['homepage'] = $row['homepage'];
		$row_array['developer'] = $row['developer'];
		array_push($system,$row_array);
    }
	$data['system'] = $system;
}

$json = json_encode($data);

//Typical JSON Error Handling
if ($json === false) {
    // Avoid echo of empty string (which is invalid JSON), and
    // JSONify the error message instead:
    $json = json_encode(array("jsonError", json_last_error_msg()));
    if ($json === false) {
        // This should not happen, but we go all the way now:
        $json = '{"jsonError": "unknown"}';
    }
    // Set HTTP response status code to: 500 - Internal Server Error
    http_response_code(500);
}


echo $json;
?>
<?PHP
include_once('config.inc.php');
include('functions/mysql_conn.php'); //Create Connection


// Check API-Key
if(!isset($_GET['apikey'])) {
	die('Welcome to the Matrix!');
}
$sql = "SELECT apikey FROM api_keys WHERE apikey=\"" . $_GET['apikey'] . "\"";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) <= 0) {
    // output data of each row
	echo '{"jsonError": "unknown API Key"}';
	die();
}

// Check FORMAT
if(isset($_GET['format'])) {
	$format = $_GET['format'];
}else{
	$format = 'json';
}

//Main
switch($format) {
	case 'json':
		include('api/json.php');
		break;
	case 'xml':
		include('api/xml.php');
		break;
	case 'html';
		include('api/html.php');
		break;
}

mysqli_close($conn);
?>
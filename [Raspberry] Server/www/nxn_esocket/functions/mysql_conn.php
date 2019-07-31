<?PHP
// Create connection
if(!isset($servername) or !isset($username) or !isset($password)or !isset($dbname)) {
	die("ERROR 403<br />No Database credentials!");
}else{
	$conn = mysqli_connect($servername, $username, $password, $dbname);
}

// Check connection
if (!$conn) {
    //die("Connection failed: " . mysqli_connect_error());
	die("ERROR 402<br />Failed to connect to Database");
}
?>
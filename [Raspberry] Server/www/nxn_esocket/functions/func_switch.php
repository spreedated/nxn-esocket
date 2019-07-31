<?PHP
if(isset($_GET["socketswitch"])) {
	$values = explode("-",$_GET["socketswitch"]);
	shell_exec('sudo ' . _pathto_sendtonodes_ . ' ' . $values[0] . ' ' . $values[1] . ' ' . $values[2]);
	echo '<script type="text/javascript">window.location = "' . _websiteurl_ . '";</script>';
	die();
}
?>

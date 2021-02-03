<?PHP
if(isset($_GET["socketswitch"])) {
	include_once('../config.inc.php');

	$values = explode("-",$_GET["socketswitch"]);
		shell_exec('sudo mosquitto_pub -t \'/neXn/433/commands/\' -m "{\"clients\":[\"all\"], \"command\":\"switch\", \"homecode\":\"'.$values[0].'\", \"socket\":\"'.$values[1].'\", \"state\":'.$values[2].'}" -h 192.168.1.106');
	return "Done";
}
?>

<?PHP
$starttime = microtime(true);

include_once('config.inc.php');

// Give $websiteurl var to JAVASCRIPT
echo '<script type="text/javascript">var websiteurl = "'. _websiteurl_ .'";</script>';

include('functions/func_switch.php');
include('functions/login.php');
?>

<html>
<head>
<meta name="viewport" content="width=480, user-scalable=no">
<link rel="icon" href="nxn_icon.ico" type="image/vnd.microsoft.icon">
<title>neXn-Systems eSocket</title>
<style type="text/css">
body {
	background-color: #000;
	color: #AAA;
	font-family: "Arial Black", Gadget, sans-serif;
	font-size: 32px;
}
#main {
	margin:auto;
	display: block;
	z-index: 1000;
}
#socketname {
	margin:auto;
	margin-bottom: 16px;
	display: block;
	width: 450px;
	height: 66px;
	overflow: hidden;
	cursor: pointer;
	padding: 6px;
}
#iconbutton {
	height:64px;
	width:64px;
	border-radius: 5px 5px 5px 5px;
	background-repeat:no-repeat;
	background-position: center;
	background-size: 90% 90%;
	position: relative;
	float: left;
	z-index: 1;
}
.webp #iconbutton {
	background-image:url('img/icons/socket.webp');
}
.no-webp #iconbutton {
	background-image:url('img/icons/socket.png');
}
#textbutton {
	margin:auto;
	height:64px;
	width:450px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	color: #fff;
	font-size: 20px;
	font-weight:bold;
	position: relative;
	z-index: 0;
}
#textbutton:hover {
	background-color: #505050;
}
#textbutton_text {
	margin-left: 72px;
	width: 100%;
	height: 100%;
	top: 50%;
	margin-top: 2px;
}

.green {
	border: solid thin #00A000;
	background-color: #44A601;
}
.red {
	border: solid thin #A00000;
	background-color: #800000;
}
#socketnumber {
	position:absolute;
	right:52px;
	top:0px;
	font-size:48px;
	color:#333;
	text-align:right;
	z-index: 1;
	height:62px;
	width:auto;
	display:inline-block;
	line-height: 60px;
}
#socketnamediv {
	position:absolute;
	margin-top:15px;
	z-index: 2;
}
#logo {
	margin: auto;
	/* background-image: url('img/logo.webp'); */
	background-position: center;
	background-repeat: no-repeat;
	width:461px;
	height:141px;
	margin-bottom: 50px;
}
.webp #logo {
	background-image: url('img/logo.webp');
}
.no-webp #logo {
	background-image: url('img/logo.png');
}
#loading {
	width: 100%;
	height: 100%;
	background-color: #000;
	background-repeat: no-repeat;
	background-position: center;
	display:none;
	z-index:9000;
	position:fixed;
	top: 0px;
	left: 0px;
}
.webp #loading {
	background-image: url('img/gears.webp');
}
.no-webp #loading {
	background-image: url('img/gears.gif');
}
#collapse_button {
	position: relative;
	cursor: pointer;
	width: auto;
	max-width: 140px;
	text-align: left;
	font-size: 9px;
	padding: 5px;
	display: block;
}

#footer_wrap {
	position: relative;
	bottom:0;
	width: auto;
	border: none;
	text-align: left;
	font-size: 9px;
	margin: auto;
}
#footer_info {
	position: relative;
	width: auto;
	border: none;
	text-align: left;
	outline: none;
	font-size: 9px;
	display: inline-block;
	float: left;
}
#footer_nodes {
	position: relative;
	bottom:0;
	width:auto;
	color: #333333;
	font-size: 9px;
}

.close {
		color: #aaa;
		float: right;
		font-size: 18px;
		font-weight: bold;
}
.close:hover,
.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
}
#version {
	position: relative;
	display: inline-block;
	font-size: 9px;
	font-style: italic;
	text-align: right;
	color: #444444;
	right: 8px;
	bottom: 4px;
	z-index: 0;
	float: right;
}
#span_measurecreationtime {
	color:#222222;
}
.cancelcross {
	color:#DD0000;
	font-size:20px;
}
.cancelcross:hover {
	color:#880000;
}

@media only screen and (max-width: 480px){
	#footer_wrap {
		zoom: 180%;
	}
	#version {
		color: #AAA;
	}
	#span_measurecreationtime {
		color: #555;
	}
	#logo {
		zoom: 50%;
		margin: 0px;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 45px;
	}
	#mdl_sign_in, #login {
		zoom: 140%;
	}
}
</style>
<link href="css/all.min.css" rel="stylesheet">
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/modernizr.webp.min.js"></script>

<!--
	RELOAD WINDOW FUNCTION
-->
<script type="text/javascript">
var timedsa = <?PHP echo  _pagerefreshinterval_; ?>;
var reloadPage = true;

$(document).ready(function() {
	setInterval(function(){
		timedsa -= 1;
		if (timedsa <= 0 && reloadPage == true) {
			window.location.reload(true);
		}
	}, 1000);
});
</script>
<!--
	### ### ###
-->

<!--
	Animation on RESIZE at LOGO
-->
<script type="text/javascript">
var resizeTimer;
$(window).on('resize', function(e) {
	clearTimeout(resizeTimer);
	resizeTimer = setTimeout(function() {
		var win = $(this); //this = window
		if (win.width() <= 480) {
			$('#logo').animate({
				zoom: '50%'
			}, 400)
		}else{
			$('#logo').animate({
				zoom: '100%'
			}, 400)
		};
	}, 250);

});
</script>
<!--
	### ### ###
-->

<script type="text/javascript">
window.onclick = function(event) {
		if (event.target == document.getElementById('myModal')) {
				document.getElementById('myModal').style.display = "none";
		}
	if (event.target == document.getElementById('myModal_notloggedin')) {
				document.getElementById('myModal_notloggedin').style.display = "none";
		}
}
</script>

<script type="text/javascript">
function nxn_socket(dip_main,dip_second,state) {
	document.getElementById("loading").style.display = "block";

	if(parseInt(state) == 0){
		state = 1;
	}else{
		state = 0;
	}

	window.location = websiteurl + "/nxn.php?socketswitch="+dip_main+"-"+dip_second+"-"+state;
}
</script>

<script type="text/javascript">
function toggle_footer() {
	if(document.getElementById("footer_nodes").style.display == "none") {
		document.getElementById("footer_nodes").style.display = "block";
		document.getElementById("collapse_button").innerHTML = "[-] " + document.getElementById("collapse_button").innerHTML.substr(4)
	}else{
		document.getElementById("footer_nodes").style.display = "none";
		document.getElementById("collapse_button").innerHTML = "[+] " + document.getElementById("collapse_button").innerHTML.substr(4)
	}
}
</script>

</head>

<body>
<?PHP
//INCLUDE FUNCTIONS
include('functions/mysql_conn.php'); //Must be first
include('functions/cls_modalboxes.php');
include('functions/cls_socketbuttons.php');

//INLCLUDE FORMS
include('forms/notloggedin.php');
include('forms/categories.php');
if(isset($_SESSION['isloggedin']) == True AND $_SESSION['isloggedin'] = True) {
	include('forms/btn_timed_events.php');
	include('forms/btn_own_user.php');
	include('forms/btn_terminal.php');
	include('forms/btn_users_admin.php');
	include('forms/logoutform.php'); //Must be last
}else{
	include('forms/loginform.php');
}
?>

<div id="main">
		<div id="logo"></div>
		<?PHP echo categories($conn); ?>
		<div id="socketbutton_wrapper">
<?PHP

// MySQL GETS
$sql = "SELECT * FROM sockets";
$result = mysqli_query($conn, $sql);

// ### ### ### ###
// ### Create Buttons
// ### ### ### ###

if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		//Hardware state
		if ($row['hardware_active'] == false) {
			continue;
		}

		// state
		$btn_state = '';
		if ($row['state'] == 0) {
			$btn_state = "class=\"red\"";
		}else{
			$btn_state = "class=\"green\"";
		}
		// icon
		$icon = '';
		if ($row['icon'] != NULL) {
			if(file_exists('img/icons/' . $row['icon'] . '.png')) {
				if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
					$icon = "style=\"background-image:url('img/icons/" . $row['icon'] . ".webp');\" ";
				}else{
					$icon = "style=\"background-image:url('img/icons/" . $row['icon'] . ".png');\" ";
				}
			}
		}

		//icon arrange
		$needs_permit_height = '';
		$confirm_icon_heigt = '';
		if($row['needs_permit'] == 1 AND $row['needs_confirmation'] == True) {
			$needs_permit_height = '8px';
			$confirm_icon_heigt = '36px';
		}
		if($row['needs_permit'] == 1 AND $row['needs_confirmation'] == False) {
			$needs_permit_height = '22px';
		}
		if($row['needs_permit'] == 0 AND $row['needs_confirmation'] == True) {
			$confirm_icon_heigt = '22px';
		}

		// needs login
		$ok_to_operate = False;
		if ($row['needs_permit'] == 1) {
			if(isset($_SESSION['isloggedin'])) {
				if($_SESSION['isloggedin'] == True) {
					$needs_permit = '<i class="fas fa-lock-open" style="color:#44A601; position:absolute; right: 16px;top:'.$needs_permit_height.';"></i>';
					$ok_to_operate = True;
				}else{
					$needs_permit = '<i class="fas fa-lock" style="color:#AA0000; position:absolute; right: 20px;top:'.$needs_permit_height.';"></i>';
				}
			}else{
				$needs_permit = '<i class="fas fa-lock" style="color:#AA0000; position:absolute; right: 20px;top:'.$needs_permit_height.';"></i>';
			}
		}else{
			$needs_permit = '';
			$ok_to_operate = True;
		}
		//needs confirmation
		$needs_confirmation = False;
		$confirm_icon = '';
		if ($row['needs_confirmation'] == True) {
			$confirm_icon = '<i class="fas fa-window-restore" style="color:#777; position:absolute; right: 20px;top:'.$confirm_icon_heigt.';"></i>';
		}

		//Socketbutton Template
		$socketbutton = array();
		array_push($socketbutton, "<div id=\"socketname\" class=\"socketname_button\" onClick=\"");
		array_push($socketbutton, "\"><div id=\"iconbutton\" ". $icon . $btn_state . " ></div><div id=\"textbutton\" class=\"socketname_textbutton\"><div id=\"textbutton_text\"><div id=\"socketnamediv\" class=\"socketname_textbutton_controlled_device\">" . $row['controlled_device'] . "</div><div id=\"socketnumber\" class=\"socketname_textbutton\">" . $row['id'] . "</div>" . $needs_permit . $confirm_icon . "</div></div></div>");

		//Make Buttons
		if($row['needs_confirmation'] == False) {
			echo no_confirm($ok_to_operate, $row['dip_main'], $row['dip_second'], $row['state'], $socketbutton);
		}else{
			echo do_confirm($ok_to_operate, $row['dip_main'], $row['dip_second'], $row['state'], $row['controlled_device'], $row['id'], $socketbutton);
		}

	}
} else {
		echo "0 results";
}
?>

<!--
	### DEBUG BUTTON
-->

<!-- <div id="socketname" onclick="" style="width: 230px;">
	<div id="iconbutton" style="background-color:#777; height:65px"></div>
	<div id="textbutton" style="width: 230px; ">
		<div id="textbutton_text">
			<div id="socketnamediv">Timed Events</div>
		</div>
	</div>
</div> -->


<!--
	### ### ### ### ###
-->
	</div> <!-- Socketbutton Wrapper -->

</div>

<!--
	### FOOTER NODES
-->
<div id="footer_wrap">
<div style="color: #44A601;font-size: 24px; display:inline-block;float: left; margin-right: 4px;"><i class="fas fa-broadcast-tower"></i></div>
<?PHP
$sql = "SELECT COUNT(*) AS total FROM sockets";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
				echo "<div id=\"footer_info\">Number of connected sockets <span style=\"color:#44A601\">". $row['total'] . "</span></div>";
		}
}
?>
<!--
	### VERSION DIV
-->
<div id="version">
<p style="margin:0px;padding:0px;">
<?PHP
$sql = "SELECT * FROM system";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
				echo 'Version ' . $row['versionstring'] . '<br />';
		}
}
?>
	2019 &copy; ne<span style="color:#44A601">X</span>n-Systems<br />
	<?PHP $endtime = microtime(true); ?>
	<span id="span_measurecreationtime"></span>
	</p>
</div>
<!--
	### ### ###
-->

<?PHP
$sql = "SELECT COUNT(*) AS total FROM nodes";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		// output data of each row
		$endtext = "";
		while($row = mysqli_fetch_assoc($result)) {
			if($row['total'] == 1) {
				$endtext = "</span> Node active</div>";
			}else{
				$endtext = "</span> Nodes active</div>";
			}
			echo "<div id=\"collapse_button\" onClick=\"toggle_footer();\">[+] <span style=\"color:#44A601\">". $row['total'] . $endtext;
		}
}
?>


<div id="footer_nodes" style="display:none;">
<?PHP
$sql = "SELECT id,ip,port,location,is_active,name FROM nodes";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$offlinetext = "";
			if (!$row['is_active']) {
				$offlinetext = "<span style=\"color:#FF0000; text-weight: bold;\"> [OFFLINE]</span>";
			}
			echo 'Id: ' . $row['id'] . ' -- IP: ' . $row['ip'] . ' -- Port: ' . $row['port'] . ' -- Location: ' . $row['location'] . ' -- Name: ' . $row['name'] . $offlinetext . '<br/>';
		}
} else {
		echo "0 results";
}
?>
</div>
<!--
	### ### ### ### ###
-->


</div>

<div id="loading"></div>
<!--
	JavaScript for View Handling
-->
<script src="js/cookie_handling.js"></script>
<script src="js/view_change.js"></script>
<!--
	### ### ###
-->
</body>
</html>
<?PHP
mysqli_close($conn);
//Give full creation time to JAVASCRIPT
$creationtimeintotal = round(($endtime - $starttime),4);
echo '<script type="text/javascript">'.
	'var creationtime="'.$creationtimeintotal.'";'.
	'document.getElementById(\'span_measurecreationtime\').innerHTML = "Created in " + creationtime + "ms";' .
'</script>';
?>

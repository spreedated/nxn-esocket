<?PHP
define('_company_','neXn-Systems');
define('_homepage_','nexn.systems');
define('_developer_','Markus Karl Wackermann');
define('_version_','2.10.3');

$starttime = microtime(true);

include_once('config.inc.php');

// Give $websiteurl var to JAVASCRIPT
echo '<script type="text/javascript">var websiteurl = "'. _websiteurl_ .'";</script>';

include('functions/login.php');
?>

<html>
<head>
<meta name="viewport" content="width=480, user-scalable=no">
<link rel="icon" href="nxn_icon.ico" type="image/vnd.microsoft.icon">
<title>neXn-Systems eSocket</title>
<style type="text/css">
@font-face {
	font-family: lcars;
	src: url('fonts/lcarsgtj3.ttf');
}
body {
	background-color: #000;
	background-position: center;
	background-blend-mode:screen;
	color: #AAA;
	font-family: "Arial Black", Gadget, sans-serif;
	font-size: 32px;
}
.webp body {
	background-image:url('img/bg.webp');
}
.no-webp body {
	background-image:url('img/bg.jpg');
}
#main {
	margin:auto;
	display: block;
	z-index: 1000;
}
#logo {
	margin: auto;
	background-position: center;
	background-repeat: no-repeat;
	background-size: contain;
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
.button {
	margin:auto;
	display: block;
	width: 450px;
	height: 66px;
	overflow: hidden;
	cursor: pointer;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
}
.button:hover {
	background-color: #505050;
}
.button_row {
	margin:auto;
	margin-bottom: 16px;
	text-align: center;
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
	left: -2px;
	display: inline-block;
	z-index: 1;
	background-image:url('img/icons/socket.svg');
}
#textbutton {
	margin:auto;
	height:64px;
	width:380px;
	display: inline-block;
	color: #fff;
	font-size: 20px;
	font-weight:bold;
	position: relative;
	z-index: 0;
}
#textbutton_text {
	margin-left: 8px;
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
	height:64px;
	width:auto;
	display:inline-block;
	line-height: 64px;
	font-family: lcars;
	font-weight: normal;
}
#socketnamediv {
	position:absolute;
	margin-top:15px;
	z-index: 2;
}
.loading {
	width: 100%;
	height: 100%;
	background-size: contain;
	background-color: #000;
	background-repeat: no-repeat;
	background-position: center;
	display: none;
	z-index:9000;
	background-image: url('img/ripple.svg');
}
#collapse_button {
	position: relative;
	cursor: pointer;
	width: 250px;
	height: auto;
	text-align: left;
	font-size: 9px;
	display: inline-block;
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
#nodeInfoDIV {
	position: relative;
	display: inline-block;
	left: 8px;
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
	display: block;
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
.ui-effects-transfer {
	border: 2px dotted gray;
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
<link href="css/jquery-ui.1.12.1.min.css" rel="stylesheet" />
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/jquery-ui.1.12.1.min.js"></script>
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
//Using jQuery
function nxn_socket(housecode, socketcode, state, buttonid, socketName) {
	//If offline, set on and vice versa
	state = (parseInt(state) == 0) ? 1 : 0;

	$(document.body).css({'cursor' : 'progress'});
	$("#"+buttonid).prepend('<div class="loading"></div>');
	$("#"+buttonid+ " .loading").fadeIn(400, function(){
		$.get("functions/func_switch.php?socketswitch="+housecode+"-"+socketcode+"-"+state, function(data, status) {
			if(state == 0) {
				$("#"+buttonid + " #iconbutton").addClass("red");
				$("#"+buttonid + " #iconbutton").removeClass("green");
			}else{
				$("#"+buttonid + " #iconbutton").addClass("green");
				$("#"+buttonid + " #iconbutton").removeClass("red");
			}
			//Refresh ONCLICK function
			if ($("#"+buttonid).attr("onclick").indexOf('show_confirmbox') >= 0 ) {
				$("#"+buttonid).attr("onclick","show_confirmbox('"+socketName+"', function() {nxn_socket('"+housecode+"','"+socketcode+"','"+state+"','"+buttonid+"','"+socketName+"');});");
			}else {
				$("#"+buttonid).attr("onclick","nxn_socket('"+housecode+"', '"+socketcode+"', '"+state+"', '"+buttonid+"','"+socketName+"');");
			}

			$("#"+buttonid+ " .loading").fadeOut(400, function(){
				$(document.body).css({'cursor' : 'default'});
				$("#"+buttonid).remove('.loading');
			});
		});
	});
}
</script>

<script type="text/javascript">
function toggle_footer() {
	if($("#footer_nodes").css('display') == "none") {
		$('#collapse_button').html("[-] " + $('#collapse_button').html().substr(4));
	}else{
		$('#collapse_button').html("[+] " + $('#collapse_button').html().substr(4));
	}
	$('#footer_nodes').toggle('fold');
}
</script>

</head>

<body>
<?PHP
//INCLUDE FUNCTIONS
include('functions/mysql_conn.php'); //Must be first
include('functions/cls_modalboxes.php');

//INLCLUDE FORMS
if(isset($_SESSION['isloggedin']) == True AND $_SESSION['isloggedin'] = True) {
	include('forms/btn_own_user.php');
	include('forms/btn_terminal.php');
	include('forms/logoutform.php'); //Must be last
}else{
	include('forms/loginform.php');
}
?>

<div id="main">
		<div id="logo"></div>
		<div id="socketbutton_wrapper">
<?PHP

// MySQL GETS
$sql = "SELECT id, housecode, socketcode, controlled_device, hardware_active, state, needs_permit, needs_confirmation, icon, displayOrder FROM sockets ORDER BY displayOrder, id ASC";
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
			$iconpath = 'img/icons/' . $row['icon'] . '.svg';
			if(file_exists($iconpath)) {
				$icon = "style=\"background-image:url(".$iconpath.");\" ";
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

		//Socketname with ID
		$id = "socketname" . $row['id'];

		//Socketbutton Template
		$socketbutton = array();
		array_push($socketbutton, "<div id=\"button_row\" class=\"button_row\"><div id=\"socketname" . $row['id'] . "\" class=\"button\" onClick=\"");
		array_push($socketbutton, "\"><div id=\"iconbutton\" ". $icon . $btn_state . " ></div><div id=\"textbutton\" class=\"socketname_textbutton\"><div id=\"textbutton_text\"><div id=\"socketnamediv\" class=\"socketname_textbutton_controlled_device\">" . $row['controlled_device'] . "</div><div id=\"socketnumber\" class=\"socketname_textbutton\">" . $row['id'] . "</div>" . $needs_permit . $confirm_icon . "</div></div></div></div>");

		//Create Buttons
		$output = "";
		switch($ok_to_operate) {
			case True:
				if ($row['needs_confirmation']) {
					$output .= $socketbutton[0] . "show_confirmbox('".$row['controlled_device']."', function() {nxn_socket('".$row['housecode']."','".$row['socketcode']."','".$row['state']."','socketname". $row['id'] . "','" . $row['controlled_device'] ."');});" . $socketbutton[1];
				}else{
					$output .= $socketbutton[0] . "nxn_socket('".$row['housecode']."','".$row['socketcode']."','".$row['state']."','socketname". $row['id'] . "','" . $row['controlled_device'] ."');" . $socketbutton[1];
				}
				break;
			case False:
				$output .= $socketbutton[0] . "show_noPermission();" . $socketbutton[1];
				break;
		}
		echo $output;
		//# ### #
	}
} else {
		echo "0 results";
}
?>
	</div> <!-- Socketbutton Wrapper -->

</div>

<!--
	### FOOTER NODES
-->
<div id="footer_wrap">
<div id="nodeInfoDIV">
<div style="color: #44A601;font-size: 24px; display:inline-block;float: left; margin-right: 4px;"><i class="fas fa-broadcast-tower"></i></div>
<?PHP
$sql = "SELECT COUNT(id) AS total, SUM(CASE WHEN hardware_active = 1 THEN 1 ELSE 0 END) as active FROM sockets";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
				echo "<div id=\"footer_info\">Active/Total sockets <span style=\"color:#44A601\">". $row['active'] . "/". $row['total'] . "</span></div><br />";
		}
}
?>

<?PHP
$sql = "SELECT COUNT(id) AS total, SUM(CASE WHEN is_active = 0 AND is_inUSE = 1 THEN 1 ELSE 0 END) AS inactiveNodes, SUM(CASE WHEN is_inUSE = 0 THEN 1 ELSE 0 END) AS unusedNodes FROM nodes";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);

		$endtext = "";
		if($row['total'] == 1) {
			$endtext .= "Node active";
		}else{
			$endtext .= "Nodes active";
		}

		if ($row['unusedNodes'] > 0) {
			$endtext .= ' - ' . $row['unusedNodes'] . ' unused Nodes';
		}

		if ($row['inactiveNodes'] > 0) {
			$endtext .= "<span style=\"color:#FF0000; text-weight: bold; margin-left: 3px;\"><i id=\"warning\" class=\"fal fa-exclamation-triangle\"></i></span> ";
			$endtext .= "<script>(function pulse(){\$('#warning').delay(200).fadeOut('slow').delay(50).fadeIn('slow',pulse);})();</script>";
		}

		echo "<div id=\"collapse_button\" onClick=\"toggle_footer();\">[+] <span style=\"color:#44A601\">". $row['total'] . "</span> " . $endtext . "</div>";
}
?>

<div id="footer_nodes" style="display:none;">
<?PHP
$sql = "SELECT id, ip, port, location, is_active, is_inUSE, name FROM nodes";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$Sign = "";
			if (!$row['is_active'] && $row['is_inUSE']) {
				$Sign = "<span style=\"color:#FF0000; text-weight: bold;\"><i class=\"fal fa-exclamation-triangle\"></i></span> ";
			}
			if (!$row['is_inUSE']) {
				$Sign = "<span style=\"color:#DDDDDD; text-weight: bold;\"><i class=\"fas fa-expand-wide\"></i></span> ";
			}
			if ($row['is_active'] && $row['is_inUSE']) {
				$Sign = "<span style=\"color:#FFFFFF; text-weight: bold;\"><i class=\"far fa-check-circle\"></i></span> ";
			}
			echo $Sign . 'Id: ' . $row['id'] . ' -- IP: ' . $row['ip'] . ' -- Port: ' . $row['port'] . ' -- Location: ' . $row['location'] . ' -- Name: ' . $row['name'] . '<br/>';
		}
} else {
		echo "0 results";
}
?>
</div>
</div>
<!--
	### ### ### ### ###
-->
<!--
	### VERSION DIV
-->
<div id="version">
<p style="margin:0px;padding:0px;">
<?PHP
echo 'Version ' . _version_ . '<br />';
echo '<script>document.title = document.title + \' v\' + \''._version_.'\'</script>';
?>
	2019 &copy; ne<span style="color:#44A601">X</span>n-Systems<br />
	<?PHP $endtime = microtime(true); ?>
	<span id="span_measurecreationtime"></span>
	</p>
</div>
<!--
	### ### ###
-->
</div><!-- ### END FOOTER ### -->

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

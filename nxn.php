<?PHP
if(isset($_GET["socket1"])) {
	shell_exec('sudo /src/raspberry-remote/send 10011 1 ' . strval($_GET["socket1"]));
	shell_exec('sudo /root/send_to_nodes.py 1 ' . strval($_GET["socket1"]));
}
if(isset($_GET["socket2"])) {
	shell_exec('sudo /src/raspberry-remote/send 10011 2 ' . strval($_GET["socket2"]));
	shell_exec('sudo /root/send_to_nodes.py 2 ' . strval($_GET["socket2"]));
}
if(isset($_GET["socket1"]) or isset($_GET["socket2"])) {
	echo '<script type="text/javascript">window.location = "http://192.168.1.105:81/nxn_esocket/";</script>';
}
?>


<html>
<head>
<meta name="viewport" content="width=480, user-scalable=no">
<link rel="icon" href="nxn_icon.ico" type="image/vnd.microsoft.icon">
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
}
button {
	height:50px;
	width:100%;
	max-width: 350px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #00A000;
	background-color: #008000;
	color: #fff;
	font-size: 24px;
	font-weight:bold;
	margin-top:10px;
}
.red {
	border: solid thin #A00000;
	background-color: #800000;
}
#socket {
	margin:auto; 
	text-align: center; 
	width:500px;
	margin-bottom: 70px;
}
#logo {
	margin: auto;
	background-image: url('logo.png');
	width:461px;
	height:141px;
	margin-bottom: 50px;
	
}
#loading {
	width: 100%;
	height: 100%;
	background-color: #000;
	background-image: url('gears.gif');
	background-repeat: no-repeat;
	background-position: center;
	border-radius: 20px 20px 20px 20px;
	display:none;
	z-index: 9000;
	position: absolute;
	top: 0px;
	left: 0px;
}
</style>
<script type="text/javascript">
function nxn_socket1(myval) {
	show_loader()
	document.getElementById("socket1").value = myval;
	document.getElementById("nxn_socket1").submit();
}
function nxn_socket2(myval) {
	show_loader()
	document.getElementById("socket2").value = myval;
	document.getElementById("nxn_socket2").submit();
}
function show_loader() {
	document.getElementById("loading").style.display = "block";
}
</script>
</head>

<body>


<div id="main">
		<div id="logo">
		</div>
		
		<form id="nxn_socket1" action="nxn.php" method="get">
		<div id="socket">
			<p style="margin:auto">Steckdose 1 (Schrank)<input type="radio" id="socket1" name="socket1" value="1" checked style="display:none"></p>
			<button type="button" onClick="show_loader(); setTimeout(function() {nxn_socket1('1');}, 500);">ON</button><br />
			<button class="red" type="button" onClick="show_loader(); setTimeout(function() {nxn_socket1('0');}, 500);">OFF</button>
		</div>
		</form>
		
		<form id="nxn_socket2" action="nxn.php" method="get">
		<div id="socket">
			<p style="margin:auto">Steckdose 2 (3D Drucker)<input type="radio" id="socket2" name="socket2" value="1" checked style="display:none"></p>
			<button type="button" onClick="show_loader(); setTimeout(function() {nxn_socket2('1');}, 500);">ON</button><br />
			<button class="red" type="button" onClick="show_loader(); setTimeout(function() {nxn_socket2('0');}, 500);">OFF</button>
		</div>
		</form>
		
	</form>
</div>

<div id="loading"></div>


</body>
</html>

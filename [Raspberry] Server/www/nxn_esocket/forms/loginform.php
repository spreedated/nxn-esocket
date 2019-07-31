<style type="text/css">
#login {
	 width: auto;
	 height:auto;
	 position:absolute;
	 top: 8px;
	 background-color: rgba(0,0,0,0.6);
	 border-radius: 10px 10px 10px 10px;
	 text-align: right;
	 padding: 0px;
	 right:8px;
}
#loginbutton {
	height:24px;
	width:48px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	color: #fff;
	font-size: 12px;
	font-weight:none;
	position: relative;
	text-align: center;
	cursor: pointer;
	margin:0px;
	margin-bottom:4px;
	margin-left:-6px;
	width:30px;
	display: inline-block;
}
#loginbutton_text {
	top:12%;
	left:0px;
	text-align:center;
	width: 100%;
	position: absolute;
}
#loginbutton:hover {
	background-color: #505050;
}
.inputbox {
	border-radius: 8px 8px 8px 8px;
	background-color: #333333;
	color: #AAAAAA;
	width: 180px;
	border: solid thin #606060;
	font-size: 16px;
	padding: 2px;
}
.inputbox:hover {
	border: solid thin #00FF00;
}
.inputbox:focus {
	border: solid thin #00AA00;
	outline: none;
}
.modal_sign_in {
		display: none;
		position: fixed;
		z-index: 2000;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0,0,0);
		background-color: rgba(0,0,0,0.6);
}
.modal_sign_in-content {
		padding: 10px;
	width: 290px;
	min-height: 100px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	position: absolute;
	top: 42px;
	float: right;
	right: 20px;
	font-weight: normal;
}
#override {
	width: 120px;
	height: 20px;
	margin: 8px;
	color: #fff;
	display: none;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #000000;
}
#longbutton {
	height:24px;
	width:68px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #000;
	color: #fff;
	font-size: 36px;
	font-weight:none;
	position: relative;
	text-align: center;
	cursor: pointer;
	margin:0px;
	margin-bottom:4px;
	margin-left:-6px;
	display: block;
}
#longbutton div {
	top:12%;
	left:0px;
	text-align:center;
	position: absolute;
}
#longbutton:hover {
	background-color: #202020;
}
</style>
<script type="text/javascript">
function show_login() {
		//document.getElementById('mdl_sign_in').style.display = "block";
		// $('#mdl_sign_in').css('display','block');
		 $('#mdl_sign_in').fadeIn(400);
}
function close_login() {
		//document.getElementById('mdl_sign_in').style.display = "none";
		$('#mdl_sign_in').fadeOut(400);
}
function show_override() {
		//document.getElementById('override').style.display = "block";
		$('#override').slideDown(400);
}
</script>
<div id="login">
	<div style="position:relative; width:auto; height:auto;">
		<!--
			View Button
		-->
		<div id="loginbutton" class="inline_linebreak " onclick="view_change();"><div id="loginbutton_text" style="text-align:center;"><i id="view_change_icon" class="fas fa-th-large" style="font-size:14px; color:#AAA; margin-top:2px;"></i></div></div>
	</div>


	<!--
		Refresh Button
	-->
	<div id="loginbutton" class="inline_linebreak" onclick="window.location = '<?PHP echo _websiteurl_; ?>';"><div id="loginbutton_text" style="text-align:center;"><i class="far fa-redo-alt" style="font-size:14px; color:#AAA; margin-top:2px;"></i></div></div>
	<!--
		Login Button
	-->
	<div id="loginbutton" onClick="show_login();" style="width:30px;"><div id="loginbutton_text"><i class="far fa-sign-in-alt" style="font-size:18px; color:#00BB00;"></i></div></div>

</div>

<div id="mdl_sign_in" class="modal_sign_in">

	<!-- Modal content -->
	<div class="modal_sign_in-content">
		<span class="close" onclick="close_login()"><i class="fas fa-times-square cancelcross"></i></span>
		<form id="login_form" action="nxn.php" method="post" style="padding:0px;margin:0px;">
		<p style="margin:0; margin-left: 24px; margin-bottom:5px; font-size:24px; color: #FFF"><i class="far fa-sign-in-alt" style="font-size:24px;"></i> Sign In</p>
		<table style="width:100%; font-size:12px; font-weight:5px;">
			<tr>
				<td width="20%">Username:</td>
				<td><input type="text" name="username" class="inputbox"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="current-password" autocomplete="off" class="inputbox"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><div id="textbutton" style="width:120px; height:24px; font-size:16px; margin: auto; cursor: pointer; line-height:24px;" onclick="document.forms['login_form'].submit();">Login</div></td>
			</tr>
		</table>
	</form>
	</div>

</div>

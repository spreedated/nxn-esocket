<style type="text/css">
.loggedin_text {
	font-size:10px;
	position:relative;
	margin-bottom:8px;
	text-align:right;
}
#logout {
	 width: auto;
	 height:auto;
	 position:absolute;
	 top: 8px;
	 background-color: rgba(0,0,0,0.6);
	 border-radius: 10px 10px 10px 10px;
	 text-align: right;
	 padding: 8px;
	 right:8px;
}
#smalliconbutton {
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
#logoutbutton_text {
	top:12%;
	left:0px;
	text-align:center;
	width: 100%;
	position: absolute;
}
#smalliconbutton:hover {
	background-color: #505050;
}
#logout_responsive {
	display:none;
	width: auto;
	height: auto;
	position:absolute;
	background-color: rgba(0,0,0,0.6);
	border-radius: 10px 10px 10px 10px;
	text-align: right;
	padding: 8px;
	right: 24px;
	top: 24px;
	line-height: 36px;
	cursor: pointer;
}
#logout_responsive_close {
	display:none;
	position: absolute;
	left: 20px;
	top: 20px;
	width: auto;
	height: auto;
	z-index: 9999;
	cursor: pointer;
	line-height: 36px;
}
@media only screen and (max-width: 480px){
	#logout {
		display: none;
	}
	#logout_responsive {
		display: block;
	}
}
</style>

<script type="text/javascript">
function show_responsive_logout() {
	document.getElementById('logout').style.position = 'relative';
	document.getElementById('logout').style.zoom = '200%';
	document.getElementById('logout').style.padding = '0';
	document.getElementById('logout').style.textAlign = 'center';

	$('#logout_responsive').slideUp(400, function() {
		$('#logout').show(1000, function() {
			$('#logout_responsive_close').show(400)
		});
		$('#logo').fadeOut(400);
	});
}

function close_responsive_logout() {
	document.getElementById('logout').style.position = 'relative';
	document.getElementById('logout').style.zoom = '200%';
	document.getElementById('logout').style.padding = '0';
	document.getElementById('logout').style.textAlign = 'center';

	$('#logout_responsive_close').slideUp(400);
	$('#logout').hide(800);
	$('#logout_responsive').slideDown(400);
	$('#logo').fadeIn(400);
}
</script>

<div id="logout_responsive" onclick="show_responsive_logout();">
	<i class="fas fa-bars" style="font-size:36px; color:#00BB00;"></i>
</div>

<div id="logout_responsive_close" onclick="close_responsive_logout();">
	<i class="far fa-arrow-square-up" style="font-size:36px; color:#BBBB00;"></i>
</div>

<!--
	AJAX reload
-->
<!-- <script>
$(document).ready(function(){
	setInterval(function(){
		$("#logout").load('forms/logoutform.php')
	}, 2000);
});
</script> -->
<!--
	# ### ### ###
-->

<div id="logout">
	<div class="loggedin_text"><?PHP if(isset($_SESSION['loggedinusername'])) { echo 'User <span style="text-decoration: underline;">' . $_SESSION['loggedinusername'] . '</span><br /><p style="opacity:0.5;">Last login<br/> ' . $loggedin_last_login . '</p>'; }else{ die('ERROR 409 - Something went wrong!'); } ?></div>
	<?PHP
		//ONE main SQL Query
		$mainsql_logoutform = 'SELECT show_raspinfo,allow_terminal FROM users WHERE username=\'' . $_SESSION['loggedinusername'] . '\' LIMIT 1';
		$result_mainsql_logoutform = mysqli_query($conn, $mainsql_logoutform);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result_mainsql_logoutform)) {
				$allowed_show_raspinfo = ($row['show_raspinfo'] ? true : false);
				$allowed_terminal = ($row['allow_terminal'] ? true : false);
			}
		}else{
			echo 'ERROR 487 - Out of luck!';
		}
	?>
	<!--
			Raspberry Info
	-->
	<?PHP
		if($_SESSION['isloggedin'] == True AND $allowed_show_raspinfo == true) {
			/*echo'<script>'.
			'function call_rpiinfo() {'.
				'$(document.body).css({\'cursor\' : \'progress\'});'.
				'$("#raspberry_info_wrapper").load(\'functions/func_show_raspinfo.php\');'.
				'$(document.body).css({\'cursor\' : \'default\'});'.
			'}'.
			'</script>';*/
			echo'<script>'.
			'function call_rpiinfo() {'.
				'$(document.body).css({\'cursor\' : \'progress\'});'.
					'$("#raspberry_info_wrapper").slideUp( 400, function(){ '.
						'$("#raspberry_info_wrapper").load(\'functions/func_show_raspinfo.php\', function() {'.
							'$("#raspberry_info_wrapper").slideDown( 1000 );$(document.body).css( {'.
								'\'cursor\' : \'default\''.
							'});'.
						'});'.
				'});'.
			'};'.
			'</script>';

			echo '<div id="raspberry_info_wrapper" class="loggedin_text">' .
							'<i class="far fa-microchip" onClick="call_rpiinfo();" style="cursor:pointer; color:#ffffff; font-size:24px; display:inline-block; vertical-align:top; margin-right:8px;"></i>'.
				'</div>';
		}
	?>
	<div style="position:relative; width:auto; height:auto;">
		<!--
			Own User Admin Button
		-->
		<div id="smalliconbutton" onclick="show_mdl_own_user();"><div id="logoutbutton_text" style="text-align:center;"><i class="far fa-user" style="font-size:18px; color:#00BB00;"></i></div></div>
		<!--
			Terminal Button
		-->
		<?PHP
		if($_SESSION['isloggedin'] == True AND $allowed_terminal == true) {
			//Terminal Events Settings Button
			echo '<div id="smalliconbutton" onclick="show_mdl_terminal();"><div id="logoutbutton_text" style="text-align:center;"><i class="far fa-terminal" style="font-size:18px;"></i></div></div>';
		}
		?>
	</div>
	<!--
		Refresh Button
	-->
	<div id="smalliconbutton" class="inline_linebreak" onclick="window.location = '<?PHP echo _websiteurl_; ?>';"><div id="logoutbutton_text" style="text-align:center;"><i class="far fa-redo-alt" style="font-size:14px; color:#AAA; margin-top:2px;"></i></div></div>
	<!--
		Logout Button
	-->
	<div id="smalliconbutton" class="inline_linebreak" onclick="document.getElementById('modal_confirmation_logout').style.display = 'flex';"><div id="logoutbutton_text" style="text-align:center;"><i class="far fa-sign-out-alt" style="font-size:18px; color:#BB0000;"></i></div></div>
	<!--
		Invisible Checkbox for Logout
	-->
	<form id="logout_form" action="nxn.php" method="post"><div style="display:none;"><input type="checkbox" id="logout" name="logout" value="1" checked></div></form>
</div>
<?PHP
echo mdl_yes_no('logout','Logout?','document.forms[\'logout_form\'].submit();');
?>

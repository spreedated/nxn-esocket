<style type="text/css">
.mdl_own_user {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,80,40,0.6);
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.mdl_own_user-content {
    padding: 10px;
	width: 450px;
	min-height:44px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	position: relative;
	font-weight: normal;
	text-align:center;
}
#mdl_own_user_text {
	width: 100%;
}
#mdl_own_user_text tr {

}
#mdl_own_user_text td {
	font-size: 12px;
	color: #FFF;
	padding: 4px;
	text-align: left;
	vertical-align: center;
}
.inputbox_username {
	border-radius: 8px 8px 8px 8px;
	background-color: #333333;
	color: #AAAAAA;
	width: 100%;
	border: solid thin #606060;
	font-size: 16px;
	padding: 2px;
	display:none;
}
.inputbox_username:hover {
	border: solid thin #00FF00;
}
.inputbox_username:focus {
	border: solid thin #00AA00;
	outline: none;
}
.inputbox_password {
	border-radius: 8px 8px 8px 8px;
	background-color: #333333;
	color: #AAAAAA;
	width: 50%;
	border: solid thin #606060;
	font-size: 16px;
	padding: 2px;
	display:none;
}
.inputbox_password:hover {
	border: solid thin #00FF00;
}
.inputbox_password:focus {
	border: solid thin #00AA00;
	outline: none;
}

.inputbox_login_timeout {
	border-radius: 8px 8px 8px 8px;
	background-color: #333333;
	color: #AAAAAA;
	width: 20%;
	border: solid thin #606060;
	font-size: 16px;
	padding: 2px;
	display:none;
}
.inputbox_login_timeout:hover {
	border: solid thin #00FF00;
}
.inputbox_login_timeout:focus {
	border: solid thin #00AA00;
	outline: none;
}
</style>
<script type="text/javascript">
function show_mdl_own_user() {
    document.getElementById('mdl_own_user').style.display = "flex";
		reloadPage = false;
}
function close_mdl_own_user() {
    document.getElementById('mdl_own_user').style.display = "none";
		reloadPage = true;
}

function check_before_submit_own_user() {
    if (document.getElementById("show_raspinfo").checked == true) {
		document.getElementById("show_raspinfo").value = "1";
    }else{
		document.getElementById("show_raspinfo").checked = true;
		document.getElementById("show_raspinfo").value = "0";
	}
	document.forms['form_own_user'].submit();
}

function on_username_change_show_input() {
	document.getElementById("input_username").style.display = "block";
	document.getElementById("plain_username").style.display = "none";
	document.getElementById("edit_username").setAttribute("onClick", "send_new_username();");
	document.getElementById("edit_username").setAttribute("class", "far fa-check");
	document.getElementById("edit_username").setAttribute("style", document.getElementById("edit_username").getAttribute("style") + "color:#00FF00;");
}
function send_new_username() {
	document.forms['form_username'].submit();
}

function on_password_change_show_input() {
	document.getElementById("input_password").style.display = "inline-block";
	document.getElementById("input_password_confirm").style.display = "inline-block";
	document.getElementById("plain_password").style.display = "none";
	document.getElementById("edit_password").setAttribute("onClick", "send_new_password();");
	document.getElementById("edit_password").setAttribute("class", "far fa-check");
	document.getElementById("edit_password").setAttribute("style", document.getElementById("edit_password").getAttribute("style") + "color:#00FF00;");
}
function send_new_password() {
	var pass1 = document.getElementById("input_password").value;
	var pass2 = document.getElementById("input_password_confirm").value;
	if(pass1 == pass2) {
		document.forms['form_password'].submit();
	}else{
		alert('Passwords DO NOT match!');
	}
}

function on_login_timeout_change_show_input() {
	document.getElementById("input_login_timeout").style.display = "inline-block";
	document.getElementById("plain_login_timeout").style.display = "none";
	document.getElementById("edit_login_timeout").setAttribute("onClick", "send_new_login_timeout();");
	document.getElementById("edit_login_timeout").setAttribute("class", "far fa-check");
	document.getElementById("edit_login_timeout").setAttribute("style", document.getElementById("edit_login_timeout").getAttribute("style") + "color:#00FF00;");
}
function send_new_login_timeout() {
	document.forms['form_login_timeout'].submit();
}

</script>
<?PHP
$shell_output_box = '';
$modal_show = '';

//CHANGE USERNAME FUNCTION IS IN "login.php" !!!!
//CHANGE PASSWORD FUNCTION IS IN "login.php" !!!!

if(isset($_POST['show_raspinfo'])) {
	$sql = 'UPDATE users SET show_raspinfo=\''.$_POST['show_raspinfo'].'\' WHERE username=\'' . $_SESSION['loggedinusername'] . '\';';
	mysqli_query($conn,$sql);
}
if(isset($_POST['input_login_timeout'])) {
	$sql = 'UPDATE users SET login_timeout=\''. intval($_POST['input_login_timeout']).'\' WHERE username=\'' . $_SESSION['loggedinusername'] . '\';';
	mysqli_query($conn,$sql);
}

?>
<div id="mdl_own_user" class="mdl_own_user">
	<div class="mdl_own_user-content">
		<span class="close" onClick="close_mdl_own_user();"><i class="fas fa-times-square cancelcross"></i></span>
		<div style="font-size:18px; text-align:center;"><span style="color:#FFFFFF;"><i class="far fa-user" style="font-size:20px; color:#00BB00;"></i> Edit your user</span></div>
		<hr />
		<div style="overflow-x:auto;">

		<?PHP
			$sql = "SELECT * FROM users WHERE username='".$_SESSION['loggedinusername']."' LIMIT 1;";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				//Make Table
				echo '<table id="mdl_own_user_text" style="margin-bottom: 10px;">';
			// output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					//Output Data Row

					//Username
					echo '<form id="form_username" method="post" action="'. _websiteurl_ .'"><tr>' .
								'<td style="width:20%;">Username: </td>' .
								'<td style="width:100%;"><span id="plain_username">' . $row['username'] . '</span><input type="text" id="input_username" name="input_username" autocomplete="off" class="inputbox_username" value="' . $row['username'] . '"></td>' .
								'<td style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color:#555;"><i class="fas fa-pen" style="font-size:18px;"  id="edit_username" onclick="on_username_change_show_input();"></i></td>' .
							'</tr></form>';
					//Password
					echo '<form id="form_password" method="post" action="'. _websiteurl_ .'"><tr>' .
								'<td>Password: </td>' .
								'<td style="width:100%;"><span id="plain_password">********</span><input type="password" id="input_password" name="input_password" autocomplete="off" class="inputbox_password" value="*******"><input type="password" id="input_password_confirm" name="input_password_confirm" autocomplete="off" class="inputbox_password" value="*******"></td>' .
								'<td style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color:#555;"><i class="fas fa-pen" style="font-size:18px;" id="edit_password" onclick="on_password_change_show_input();"></i></td>' .
							'</tr></form>';
					//Password
					echo '<tr>' .
								'<td>Last Login: </td>' .
								'<td>' . date('d.m.Y H:i:s', $row['last_login']) . '</td>' .
								'<td >&nbsp;</td>' .
							'</tr>';
					//Login Timeout
					echo '<form id="form_login_timeout" method="post" action="'. _websiteurl_ .'"><tr>' .
								'<td>Cookie Timout: </td>' .
								'<td style="width:100%;"><input type="number" min="10" step="10" id="input_login_timeout" name="input_login_timeout" autocomplete="off" class="inputbox_login_timeout" value="' . $row['login_timeout'] . '"><span id="plain_login_timeout">' . $row['login_timeout'] . '</span> Minutes</td>' .
								'<td style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color:#555;"><i class="fas fa-pen" style="font-size:18px;" id="edit_login_timeout" onclick="on_login_timeout_change_show_input();"></i></td>' .
							'</tr></form>';
					echo '</table>';

					// ADMIN SECTION
					/*if ($row['is_admin'] == 1) {
					echo '<form id="form_own_user" method="post" action="'. _websiteurl_ .'" style="border: solid 2px #555;">';
					echo '<table id="mdl_own_user_text" style="margin-bottom: 10px;">'.
								'<th style="width:40%; height:0px;"></th>'.
								'<th style="width:100%; height:0px;"></th>';
						//Show Raspberry Info
						$raspinfo_checkbox = '';
						if($row['show_raspinfo'] == 1){
							$raspinfo_checkbox = 'value="1" checked';
						}else{
							$raspinfo_checkbox = 'value="0"';
						}
						echo '<tr>' .
									'<td>Show RPi Info: </td>' .
									'<td><input style="margin:0px;" type="checkbox" id="show_raspinfo" name="show_raspinfo" '.$raspinfo_checkbox.' /></td>' .
									'</tr>';
						// ### ### ###

						echo '<td colspan="2"><div id="textbutton" onClick="check_before_submit_own_user();" style="padding-left: 6px; padding-right: 6px; width:90px; height:24px; font-size:16px; cursor: pointer; text-align:center;margin-top:8px;display: block; line-height: 24px;">Confirm</div></td>';
						echo '</table></form>';
					}*/
					// ### ### ###

				}

			}
		?>
		</div>
	</div>
</div>

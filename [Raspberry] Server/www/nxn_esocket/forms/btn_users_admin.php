<style type="text/css">
.mdl_users_admin {
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
.mdl_users_admin-content {
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
#mdl_users_admin_text {
	width: 100%;
}
#mdl_users_admin_text th {
	font-size: 12px;
}
#mdl_users_admin_text td {
	font-size: 10px;
	color: #FFF;
	padding: 4px;
	text-align: left;
	vertical-align: center;
}
</style>
<script type="text/javascript">
function show_mdl_users_admin() {
    document.getElementById('mdl_users_admin').style.display = "flex";
		reloadPage = false;
}
function close_mdl_users_admin() {
    document.getElementById('mdl_users_admin').style.display = "none";
		reloadPage = true;
}

</script>

<div id="mdl_users_admin" class="mdl_users_admin">
	<div class="mdl_users_admin-content">
		<span class="close" onClick="close_mdl_users_admin();"><i class="fas fa-times-square cancelcross"></i></span>
		<div style="font-size:18px; text-align:center;"><span style="color:#FFFFFF;"><i class="far fa-users" style="font-size:20px; color:#999900;"></i> User Administration</span></div>
		<hr />
		<div style="overflow-x:auto;">

		<?PHP
			$sql = "SELECT * FROM users;";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				//Make Table
				echo '<table id="mdl_users_admin_text" style="margin-bottom: 10px;">';
			// output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					//Output Data Row
					echo '<th style="width:5px;">ID</th>';
					echo '<th style="width:120px;">Username</th>';
					echo '<th style="width:120px;">Last login</th>';
					echo '<th style="width:120px;">RPi Info</th>';
					echo '<th style="width:120px;">User Admin</th>';
					echo '<th style="width:120px;">Timed events</th>';
					echo '<th style="width:120px;">Terminal</th>';
					echo '<th style="width:5px; ">&nbsp;</th>';
					//Set checkboxes
					if($row['show_raspinfo'] == 1) { $raspinfo = 'checked value="1"';}else{ $raspinfo = 'value="0"';}
					if($row['allow_usersadmin'] == 1) { $usersadmin = 'checked value="1"';}else{ $usersadmin = 'value="0"';}
					if($row['allow_timedevents'] == 1) { $timedevents = 'checked value="1"';}else{ $timedevents = 'value="0"';}
					if($row['allow_terminal'] == 1) { $terminal = 'checked value="1"';}else{ $terminal = 'value="0"';}

					echo '<form id="form_username_users_admin" method="post" action="'. _websiteurl_ .'"><tr>' .
								'<td><span id="plain_username">' . $row['id'] . '</span></td>' .
								'<td><span id="plain_username">' . $row['username'] . '</span><input type="text" id="input_username_users_admin" name="input_username_users_admin" autocomplete="off" class="inputbox_username" value="' . $row['username'] . '"></td>' .
								'<td>' . date('d.m.Y H:i:s', $row['last_login']) . '</td>' .
								'<td style="text-align:center;"><input style="margin:0px;" type="checkbox" id="raspinfo" name="raspinfo" '. $raspinfo .' disabled/></td>' .
								'<td style="text-align:center;"><input style="margin:0px;" type="checkbox" id="useradmin" name="useradmin" '.$usersadmin.' disabled/></td>' .
								'<td style="text-align:center;"><input style="margin:0px;" type="checkbox" id="timed_events" name="timed_events" '.$timedevents.' disabled/></td>' .
								'<td style="text-align:center;"><input style="margin:0px;" type="checkbox" id="terminal" name="terminal" '.$terminal.' disabled/></td>' .
								'<td style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color:#880000;"><i class="far fa-trash-alt" style="font-size:18px; color:#FFF;"  id="edit_username" onclick="on_username_change_show_input();"></i></td>' .
							'</tr></form>';

					echo '<form id="form_users_admin" method="post" action="'. _websiteurl_ .'">';

				}
			echo '</table></form>';
			}
		?>

		</div>

		<!-- <div id="textbutton" onClick="check_before_submit_own_user();" style="padding-left: 6px; padding-right: 6px; width:90px; height:24px; font-size:16px; cursor: pointer; text-align:center;margin-top:8px;display: block; line-height: 24px;">Confirm</div> -->
	</div>
</div>

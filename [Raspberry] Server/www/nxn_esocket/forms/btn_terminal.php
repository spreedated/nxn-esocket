<style type="text/css">
.mdl_terminal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(40,40,40,0.6);
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.mdl_terminal-content {
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
#mdl_terminal_text {
	width: 100%;
}
#mdl_terminal_text tr {

}
#mdl_terminal_text td {
	font-size: 12px;
	color: #FFF;
	padding: 4px;
	text-align: left;
	vertical-align: center;
}
.inputbox_shell {
	border-radius: 8px 8px 8px 8px;
	background-color: #333333;
	color: #AAAAAA;
	width: 100%;
	border: solid thin #606060;
	font-size: 16px;
	padding: 2px;
}
.inputbox_shell:hover {
	border: solid thin #00FF00;
}
.inputbox_shell:focus {
	border: solid thin #00AA00;
	outline: none;
}
</style>
<script type="text/javascript">
function show_mdl_terminal() {
	document.getElementById('mdl_terminal').style.display = "flex";
	reloadPage = false;
}
function close_mdl_terminal() {
	document.getElementById('mdl_terminal').style.display = "none";
	reloadPage = true;
}
function check_before_submit_shellcommand() {
    var x;
    x = document.getElementById("shell_command").value;
    if (x.length >= 2) {
        document.forms['form_shell'].submit();
		return true;
    }else{
		alert("Command too short!");
        return false;
	}
}
</script>
<?PHP
$shell_output_box = '';
$modal_show = '';

if(isset($_POST['shell_command'])) {
	$shell_output = shell_exec($_POST['shell_command']);
	//echo $shell_output;
	$modal_show = 'display:flex;';
	$shell_output_box = '<tr><td colspan="3">' . nl2br($shell_output) . '</td></tr><script>document.getElementById("shell_command").focus();</script>';
}

?>

<div id="mdl_terminal" class="mdl_terminal" style="<?PHP echo $modal_show; ?>">
	<div class="mdl_terminal-content">
		<span class="close" onClick="close_mdl_terminal();"><i class="fas fa-times-square cancelcross"></i></span>
		<div style="font-size:18px; text-align:center;"><span style="color:#FFFFFF;"><i class="far fa-terminal" style="font-size:20px;"></i> Terminal Shell</span></div>
		<hr />
		<div style="overflow-x:auto;">
		<form id="form_shell" method="post" action="<?PHP echo _websiteurl_; ?>" onsubmit="check_before_submit_shellcommand();">
		<?PHP
			$sql = "SELECT allow_terminal FROM users WHERE username='".$_SESSION['loggedinusername']."' LIMIT 1;";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				//Make Table
				echo '<table id="mdl_terminal_text" style="margin-bottom: 10px;">';
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					//Output Data Row
					if($row['allow_terminal'] == 1) {
						//Shell Command
						echo '<tr>' .
									'<td style="width:10%;">Shell: </td>' .
									'<td style="width:100%;"><input type="text" id="shell_command" name="shell_command" autocomplete="off" class="inputbox_shell"></td>' .
									'<td onclick="check_before_submit_shellcommand();" style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color:#555;"><i class="far fa-external-link-square-alt" style="font-size:18px;"></i></td>' .
								'</tr>';
					}
				}
			echo $shell_output_box .'</table>';
			}
		?>
		</form>
		</div>
	</div>
</div>

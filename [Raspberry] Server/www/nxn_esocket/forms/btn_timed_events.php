<style type="text/css">
.mdl_timed_events {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,20,40,0.6);
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.mdl_timed_events-content {
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
#mdl_text {
	width: 100%;
	border: 1px solid #fff;
}
#mdl_text tr {
	border: 1px solid #fff;
}
#mdl_text td {
	font-size: 12px;
	color: #FFF;
	padding: 4px;
	text-align: left;
	vertical-align: center;
	border: 1px solid #fff;
}
#mdl_text tr:hover {
	background-color: #333;
}
</style>
<script type="text/javascript">
function show_mdl_timed_events() {
    document.getElementById('mdl_timed_events').style.display = "flex";
		reloadPage = false;
}
function close_mdl_timed_events() {
    document.getElementById('mdl_timed_events').style.display = "none";
		reloadPage = true;
}
</script>

<div id="mdl_timed_events" class="mdl_timed_events">
	<div class="mdl_timed_events-content">
		<span class="close" onClick="close_mdl_timed_events();"><i class="fas fa-times-square cancelcross"></i></span>
		<div style="font-size:18px; text-align:center;"><span style="color:#FFFFFF;"><i class="far fa-alarm-clock" style="font-size:20px; color:#0077BB;"></i> Timed Events</span></div>
		<hr />
		<div style="overflow-x:auto;">

		<?PHP
			$sql = "SELECT socketname,socketid,task FROM cronjobs";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				//Make Table
				echo '<table id="mdl_text" style="margin-bottom: 10px;">' .
			'<th style="width: 20px;">&nbsp;</th>' .
			'<th>Socketname</th>'.
			'<th>Task</th>' .
			'<th>Date</th>';
			// output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					// Task - DO WHAT
					if($row['task'] == 0) {
						$task = 'Off';
					}else{
						$task = 'On';
					}
					// Get ICON and display
					$sql_row_smallicon = "SELECT icon FROM sockets WHERE id='" . $row['socketid'] . "' LIMIT 1";
					$result_icon = mysqli_query($conn, $sql_row_smallicon);
					if (mysqli_num_rows($result_icon) > 0) {
						while($row_smallicon = mysqli_fetch_assoc($result_icon)) {
							$smallicon = $row_smallicon['icon'];
						}
					}
					//Output Data Row
					echo '<tr>' .
								'<td style="background-color: #555; border-radius: 6px 6px 6px 6px; background-image:url(\'img/icons/'.$smallicon.'.png\'); background-size: 24px 24px;background-repeat:no-repeat; background-position: center; width: 24px; height: 24px;">&nbsp;</td>' .
								'<td>' . $row['socketname'] . '</td>' .
								'<td style="text-align:center;">' . $task . '</td>' .
								'<td>&nbsp;</td>' .
								'<td style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color: #CCCC00;"><i class="fas fa-pen" style="font-size:18px;"></i></td>' .
								'<td style="cursor:pointer; width:20px;text-align:center; border-radius: 6px 6px 6px 6px; background-color: #AA0000;"><i class="far fa-times-circle" style="font-size:18px;"></i></td>' .
							'</tr>';

				}
			echo '</table>';
			}else{
				echo '<p>No events scheduled ;(</p>';
			}
		?>

		</div>

		<div id="textbutton" style="padding-left: 6px; padding-right: 6px; width:90px; height:24px; font-size:16px; cursor: pointer; text-align:center;margin-top:8px;display: block; line-height: 24px;" onClick="">Add new</div>
		<!--
		<div id="textbutton" style="width:60px; height:24px; font-size:16px; margin: auto; cursor: pointer; text-align:center;margin-top:8px;display: inline-block; margin-left:80px;" onClick="close_confirmbox(" . $number . ");">No</div>
		-->
	</div>
</div>

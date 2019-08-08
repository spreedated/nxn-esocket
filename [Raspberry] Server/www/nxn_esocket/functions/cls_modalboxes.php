<style type="text/css">
.modalconfirmation {
		display: none;
		position: fixed;
		z-index: 2000;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0,0,0);
		background-color: rgba(0,20,20,0.6);
		flex-direction: row;
		flex-wrap: wrap;
		justify-content: center;
		align-items: center;
}
.modalconfirmation-content {
	padding: 10px;
	width: 450px;
	height:44px;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	position: relative;
	font-weight: normal;
	text-align:center;
}
.modal_noPermission {
	display: none;
	position: fixed;
	z-index: 2000;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	background-color: rgb(0,0,0);
	background-color: rgba(20,0,0,0.6);
}
.modal_noPermission-content {
	padding: 10px;
	width: 290px;
	min-height: 60px;
	margin: auto;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	position: relative;
	top: 40%;
	font-weight: normal;
}
.modal_button {
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	width:60px;
	height:24px;
	font-size:16px;
	margin: auto;
	cursor: pointer;
	text-align:center;
	margin-top:8px;
	display: inline-block;
	line-height: 24px;
}
.modal_button:hover {
	background-color: #505050;
}
</style>
<script type="text/javascript">
function show_confirmbox(socketname, func) {
		var func = func.toString();
		func = func.substring(func.indexOf('{')+1, func.length -1);

		$('#modal_confirmation #socketname').html(socketname);
		$('#modal_confirmation #modal_yes').attr("onclick", $('#modal_confirmation #modal_yes').attr("onclick") + func );
		//$('#modal_confirmation').css("display", "flex");
		$('#modal_confirmation').fadeIn(400).css("display", "flex");
}
function close_confirmbox() {
	$('#modal_confirmation').fadeOut(200);
}
function show_noPermission() {
	$('#modal_noPermission').fadeIn(400);
}
</script>

<div id="modal_confirmation" class="modalconfirmation">
	<div class="modalconfirmation-content">
		<span class="close" onClick="close_confirmbox();"><i class="fas fa-times-square cancelcross"></i></span>
		<div style="font-size:18px; text-align:center;">Toggle <span id="socketname" style="color:#FFFFFF;"></span>?</div>
		<div id="modal_yes" class="modal_button" onClick="close_confirmbox();">Yes</div>
		<div id="modal_no" class="modal_button" style="margin-left:80px;" onClick="close_confirmbox();">No</div>
	</div>
</div>

<div id="modal_noPermission" class="modal_noPermission">
	<div class="modal_noPermission-content" style="height:auto;">
		<span class="close" onclick="$('#modal_noPermission').fadeOut(400);"><i class="fas fa-times-square cancelcross"></i></span>
		<i class="far fa-exclamation-triangle" style="color:#FF0000; display:inline-block;"></i>
		<div style="width:auto; height:auto; font-size:16px; margin: auto; text-align:center;margin-top:8px; display:inline-block;">No permission!</div>
	</div>
</div>

<?PHP

function mdl_yes_no($name,$heading,$onclickfunction) {
	return "<div id=\"modal_confirmation_" . $name . "\" class=\"modalconfirmation\">"
				. "<div class=\"modalconfirmation-content\">"
						." <span class=\"close\" onClick=\"document.getElementById('modal_confirmation_". $name ."').style.display = 'none';\"><i class=\"fas fa-times-square cancelcross\"></i></span>"
							."<div style=\"font-size:18px; text-align:center;\"><span style=\"color:#FFFFFF;\">".$heading."</span></div>"
							."<div id=\"textbutton\" style=\"width:60px; height:24px; font-size:16px; margin: auto; cursor: pointer; text-align:center;margin-top:8px;display: inline-block; line-height: 24px;\" onClick=\"".$onclickfunction."\">Yes</div>"
							."<div id=\"textbutton\" style=\"width:60px; height:24px; font-size:16px; margin: auto; cursor: pointer; text-align:center;margin-top:8px;display: inline-block; margin-left:80px; line-height: 24px;\" onClick=\"document.getElementById('modal_confirmation_". $name ."').style.display = 'none';\">No</div>"
				. "</div>"
			."</div>";
}
?>

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
.modal_notloggedin {
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
.modal_notloggedin-content {
    padding: 10px;
	width: 290px;
	min-height: 100px;
	margin: auto;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	position: relative;
	top: 40%;
	font-weight: normal;
}
</style>
<script type="text/javascript">
function show_confirmbox(number) {
    document.getElementById('modal_confirmation'+number).style.display = "flex";
}
function close_confirmbox(number) {
	document.getElementById('modal_confirmation'+number).style.display = "none";
}

function show_not_logged_in() {
	document.getElementById('myModal_notloggedin').style.display = "block";
}
function close_not_logged_in() {
    document.getElementById('myModal_notloggedin').style.display = "none";
}
</script>

<?PHP
function yes_no_socketconfirm($number,$onclickfunction,$socketname) {
	return "<div id=\"modal_confirmation" . $number . "\" class=\"modalconfirmation\">"
				. "<div class=\"modalconfirmation-content\">"
						." <span class=\"close\" onClick=\"close_confirmbox(" . $number . ");\"><i class=\"fas fa-times-square cancelcross\"></i></span>"
							."<div style=\"font-size:18px; text-align:center;\">Toggle <span style=\"color:#FFFFFF;\">".$socketname."</span>?</div>"
							."<div id=\"textbutton\" style=\"width:60px; height:24px; font-size:16px; margin: auto; cursor: pointer; text-align:center;margin-top:8px;display: inline-block; line-height: 24px;\" onClick=\"".$onclickfunction."\">Yes</div>"
							."<div id=\"textbutton\" style=\"width:60px; height:24px; font-size:16px; margin: auto; cursor: pointer; text-align:center;margin-top:8px;display: inline-block; margin-left:80px; line-height: 24px;\" onClick=\"close_confirmbox(" . $number . ");\">No</div>"
				. "</div>"
			."</div>";
}
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
function mdl_warning($warningtext, $symbol = 'fas fa-exclamation-triangle') {
	return '<div id="myModal_notloggedin" class="modal_notloggedin">' .
	  				'<div class="modal_notloggedin-content" style="height:140px;min-height:140px;">' .
	    				'<span class="close" onclick="close_not_logged_in()"><i class="fas fa-times-square cancelcross"></i></span>'.
							'<i class="'.$symbol.'" style="color:#FF0000;"></i>'.
							'<div style="width:180px; height:150px; font-size:16px; margin: auto; text-align:center;margin-top:8px;" onclick="document.forms[\'logout_form\'].submit();">'. $warningtext . '</div>'.
	  		  	'</div>'.
					'</div>';
}
?>

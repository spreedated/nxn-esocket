<?PHP
function no_confirm($ok_to_operate,$dip_main,$dip_second, $state, $socketbutton) {
	$output = "";
	switch($ok_to_operate) {
		case True:
			$output .= $socketbutton[0] . "nxn_socket('".$dip_main."','".$dip_second."','".$state."');" . $socketbutton[1];
		break;
		case False:
			$output .= $socketbutton[0] . "show_not_logged_in();" . $socketbutton[1];
		break;
	}
	return $output;
}
function do_confirm($ok_to_operate,$dip_main,$dip_second, $state, $controlled_device, $id, $socketbutton) {
	$output = "";
	switch($ok_to_operate) {
		case True:
			$output .= $socketbutton[0] . "show_confirmbox(".$id.");" . $socketbutton[1];
			$output .= yes_no_socketconfirm($id, "nxn_socket('".$dip_main."','".$dip_second."','".$state."');", $controlled_device);
		break;
		case False:
			$output .= $socketbutton[0] . "show_not_logged_in();" . $socketbutton[1];
		break;
	}
	return $output;
}

?>
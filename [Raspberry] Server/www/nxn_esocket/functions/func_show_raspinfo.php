<?PHP
//Check if Neofetch is installed
$is_neofetch = shell_exec('sudo ls /usr/bin/neofetch >> /dev/null 2>&1 && echo true || echo false');
if(strpos($is_neofetch, 'true') !== false) {
	$temp_shell = shell_exec('sudo /opt/vc/bin/vcgencmd measure_temp');
	$temp = substr($temp_shell, strpos($temp_shell,'=')+1);
	$temp = substr($temp,0, strpos($temp,'C')-1);
	$temp_shell = shell_exec('neofetch --stdout');
	//Kernel
	$kernel = substr($temp_shell, strpos($temp_shell,'Kernel:')+8);
	$kernel = substr($kernel,0, strpos($kernel,'Uptime:'));
	//CPU
	$cpu = substr($temp_shell, strpos($temp_shell,'CPU:')+5);
	$cpu = substr($cpu,0, strpos($cpu,'Memory:'));
	//Memory
	$memory = substr($temp_shell, strpos($temp_shell,'Memory:')+8);
	//$memory = substr($memory,0, strpos($memory,'Disk'));
	//Uptime
	$uptime = substr($temp_shell, strpos($temp_shell,'Uptime:')+8);
	$uptime = substr($uptime,0, strpos($uptime,'Pack'));
	$uptime = explode(',',$uptime);
	$uptime_output = '';
	foreach($uptime as $ele){ $uptime_output .= $ele.'<br/>';}
		//Raspberry Info
		echo '<div id="raspberry_info_wrapper" class="loggedin_text">' .
				'<i class="far fa-microchip" onClick="var div = document.getElementById(\'raspberry_info\'); div.style.display = div.style.display == \'none\' ? \'inline-block\' : \'none\';" style="cursor:pointer; color:#ffffff; font-size:24px; display:inline-block; vertical-align:top; margin-right:8px;"></i>' .
				'<div id="raspberry_info" style="line-height:12px;display:inline-block;vertical-align:top;text-align:left;">'.
				'<span style="color: #FFF">Temperature: </span>'.$temp.' &deg;C<br/>'.
				'<span style="color: #FFF">Kernel: </span>'. $kernel . '<br/>' .
				'<span style="color: #FFF">CPU: </span>'. $cpu . '<br/>' .
				'<span style="color: #FFF">Memory: </span>'. $memory . '<br/>' .
				'<span style="color: #FFF">Uptime: </span>'. $uptime_output .
				'</div>' .
			'</div>';
}else{
//No Neofetch installed
echo '<div id="raspberry_info_wrapper" class="loggedin_text">' .
			'<i class="far fa-microchip" onClick="var div = document.getElementById(\'raspberry_info\'); div.style.display = div.style.display == \'none\' ? \'inline-block\' : \'none\';" style="cursor:pointer; color:#ffffff; font-size:24px; display:inline-block; vertical-align:top; margin-right:8px;"></i>' .
			'<div id="raspberry_info" style="line-height:12px;display:inline-block;vertical-align:top;text-align:left;">'.
			'<span style="color: #FFF">Neofetch not installed</span><br/>'.
		'</div>' .
	'</div>';
}
?>

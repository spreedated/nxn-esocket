<?PHP
// Login
include('functions/mysql_conn.php');
include('functions/func_sha512.php');

//Start SESSION
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

function kill_session() {
	try {
		session_destroy();
	} catch (\Exception $e) {
		// Nothing...
	}
}

if(isset($_POST["logout"])) {
	try {
		unset($_COOKIE[_cookiename_]);
	} catch (Exception $e) {
		// Nothing here...
	}
	setcookie(_cookiename_,"dead",time()-1);
	kill_session();
	echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 500);</script>';
	die();
}

// Change Username Function
if(isset($_POST['input_username']) AND isset($_COOKIE[_cookiename_])) {
	$explodstr = explode('#',$_COOKIE[_cookiename_]);
	$loggedinusername = $explodstr[0];
	$sql = 'UPDATE users SET username=\''.$_POST['input_username'].'\' WHERE username=\'' . $loggedinusername . '\';';
	mysqli_query($conn,$sql);
	setcookie(_cookiename_,"dead",time()-1);
	kill_session();
	echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 500);</script>';
	die();
}
// Change Password Function
if(isset($_POST['input_password']) AND isset($_COOKIE[_cookiename_])) {
	$explodstr = explode('#',$_COOKIE[_cookiename_]);
	$loggedinusername = $explodstr[0];
	//SHA-512 with user-salt
	$cryptme = modern_openssl_sha512($_POST["input_password"]);
	$sha512password = substr($cryptme[0], strpos($cryptme[0],'20000$')+6);

	$sql = 'UPDATE users SET password=\''. $sha512password .'\', salt=\''. $cryptme[1] .'\' WHERE username=\'' . $loggedinusername . '\';';
	mysqli_query($conn,$sql);
	setcookie(_cookiename_,"dead",time()-1);
	kill_session();
	echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 500);</script>';
	die();
}

if(isset($_COOKIE[_cookiename_])) {
	$explodstr = explode('#',$_COOKIE[_cookiename_]);
	$loggedinusername = $explodstr[0];
	$_SESSION['loggedinusername'] = $explodstr[0];
	$loggedin_last_login = date('d.m.Y H:i:s', $explodstr[2]);

	//Check if is valid
	$sql = "SELECT username,password FROM users WHERE username=\"" . $loggedinusername . "\" LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($explodstr[1] == $row['password']) {
				//set Session Var
				$_SESSION['isloggedin'] = true;
			}else{
				kill_session();
				echo 'ERROR 401 <br />Corrupted Cookie! Do NOT hack!';
				setcookie(_cookiename_,"dead",time()-1);
				echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 3000);</script>';
			}
		}
	}else{
		echo 'ERROR 401 <br />Some Error in Auth check!';
		setcookie(_cookiename_,"dead",time()-1);
		kill_session();
		echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 3000);</script>';
		die();
	}
}else {
	// Kill everything
	kill_session();
}


if(isset($_POST["username"]) AND isset($_POST["current-password"])) {
	//Check MySQL
	$sql = "SELECT id,username,password,last_login,login_timeout,salt,show_raspinfo,allow_terminal FROM users WHERE username=\"" . $_POST["username"] . "\" LIMIT 1";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			//SHA-512 with user-salt
			$cryptme = modern_openssl_sha512($_POST["current-password"],$row['salt']);
			$sha512password = substr($cryptme[0], strpos($cryptme[0],'20000$')+6);

			if(strtolower($row['username']) == str_replace(' ','',strtolower($_POST["username"])) AND $row['password'] == $sha512password) {
				setcookie("nxnesocketlogin", ($row['username'] . '#' .  $row['password'] . '#' . $row['last_login']),time() + (intval($row['login_timeout'])*60));
				//Update LAST Login
				$current_timestamp = date_timestamp_get(date_create());
				$sql = "UPDATE users SET last_login=\"" . $current_timestamp  ."\" WHERE id=" . $row['id'];
				mysqli_query($conn, $sql);

				echo '<script type="text/javascript">window.location = "' . _websiteurl_ . '";</script>';
				die();
			}else{
				echo 'ERROR 407 <br />Wrong Password!';
				//echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 3000);</script>';
				die();
			}
		}
	}else{
		echo 'ERROR 405 <br />Credentials NOT FOUND!';
		echo '<script type="text/javascript">setTimeout(function(){ window.location = "' . _websiteurl_ . '"; }, 3000);</script>';
		die();
	}
}
?>

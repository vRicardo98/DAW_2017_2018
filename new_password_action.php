<?php
require_once('inc/init.php');
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$token = $_POST['token'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];

if($password != $repassword) {
	header("Location:new_password.php?error=1");
	die();
}

if($db) {	
	// criar query numa string
	$query  = "SELECT * FROM users WHERE reset_digest = '" . $token . "'";
	
	// executar a query
	if(!($result = @ mysql_query($query,$db)))
		showerror();
	
	$row = mysql_fetch_assoc($result);
	$nrows  = mysql_num_rows($result);
	
	$datetime1 = strtotime("now");
	$datetime2 = strtotime($row['reset_sent_at']);

	$secs = $datetime1 - $datetime2;// == <seconds between the two times>
	$hours = $secs / 3600;
	
	if($token && $nrows > 0 && $hours <= 1) {
		$query  = "UPDATE users SET password_digest = '" . substr(md5($password),0,32) . "' WHERE email = '" . $row["email"] . "'";
		
		// executar a query
		if(!($result = @ mysql_query($query,$db))) {
			showerror();
		}
		
		header("Location:message.php?code=2");
	}
	else {
		header("Location:message.php?code=3");
	}
}
?>
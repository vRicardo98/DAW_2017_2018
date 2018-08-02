<?php
require_once('inc/init.php');
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$email = $_POST['email'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];

if($db) {	
	// criar query numa string
	$query  = "SELECT * FROM users = '" . $reset_digest . "', reset_sent_at = CURDATE() WHERE email = '" . $email . "'";
	
	// executar a query
	if(!($result = @ mysql_query($query,$db)))
		showerror();
	
	$row = mysql_fetch_assoc($result);
	$nrows  = mysql_num_rows($result);
	
	if(isset($_GET["TOKEN"]) && ((time()*3600)-$row[reset_digest])<=1) {
		if($password == $repassword) {
			$query  = "UPDATE users SET password = '" . $password . "' WHERE email = '" . $row["email"] . "'";
			
			// executar a query
			if(!($result = @ mysql_query($query,$db))) {
				showerror();
			}
							
			$template->setCurrentBlock("FORM-MESSAGE");
			$template->setVariable('MESSAGE', '<div class="form-message">' . 'Password reset successfully!' . '</div>');
			$template->parseCurrentBlock();
			
			header("Location:message.php?code=2");
		}
		else {
			$template->setCurrentBlock("FORM-MESSAGE");
			$template->setVariable('MESSAGE', '<div class="form-message">' . 'Password confirmation does not match!' . '</div>');
			$template->parseCurrentBlock();
			
			header("Location:message.php?code=1");
		}
	}
	else {
		$template->setCurrentBlock("FORM-MESSAGE");
		$template->setVariable('MESSAGE', '<div class="form-message">' . 'ERROR: WRONG TOKEN OR TOKEN EXPIRED, PASSWORD RESET FAILED!' . '</div>');
		$template->parseCurrentBlock();
		
		header("Location:message.php?code=3");
	}
	
	/*$query  = "SELECT * FROM users = '" . $reset_digest . "', reset_sent_at = CURDATE() WHERE id = '" . users.id . "' AND email = '" . $email . "'";
				
	// executar a query
	if(!($result = @ mysql_query($query,$db))) {
		showerror();
	} 
	
	$row = mysql_fetch_assoc($result);
	//COMPLETE NEXT CODE...
	if(isset($_GET["TOKEN"]) && ((time()*3600)-$row[reset_digest])<=1) {
		
	}*/
	
	/*
	// criar query numa string
	$query  = "SELECT * FROM users WHERE email = '" . $email . "'";
	
	// executar a query
	if(!($result = @ mysql_query($query,$db)))
		showerror();
	
	$row = mysql_fetch_assoc($result);
	$nrows  = mysql_num_rows($result);
	*/
	
}
?>
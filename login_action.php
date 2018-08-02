<?php
require_once('inc/init.php');
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$email = $_POST['email'];
$password = $_POST['password'];

if($db) {
	
	// criar query numa string
	$query  = "SELECT * FROM users WHERE email = '" . $email . "'";
	
	// executar a query
	if(!($result = @ mysql_query($query,$db)))
		showerror();
	
	$row = mysql_fetch_assoc($result);
	$nrows  = mysql_num_rows($result);
	
	$error = null;
	
	if($nrows <= 0) {
		//$error = "o username/e-mail não é valido";
		$error = 1;
	} else {
		//$error = "a password não é valida";
		
		// criar query numa string
		$query  = "SELECT * FROM users WHERE email = '" . $email . "' AND password_digest = '" . substr(md5($password),0,32) . "'";
		
		// executar a query
		if(!($result = @ mysql_query($query,$db)))
			showerror();
		
		$nrows  = mysql_num_rows($result);
		
		if($nrows <= 0)
			$error = 2;
	}
	
	if ($error)
		header("Location:login.php?error=" . $error . "&email=" . $email);
	else {
		setcookie('user_id', $row["id"], time()+3600);
		if($_POST["autologin"] == 1) {
			$cookie_rememberMe = substr(md5(time()),0,32);
			setcookie('rememberMe', $cookie_rememberMe, time() + (3600 * 24 * 30));
			
			$query  = "UPDATE users SET remember_digest = '" . $cookie_rememberMe . "' WHERE id = '" . $row["id"] . "'";
				
			// executar a query
			if(!($result = @ mysql_query($query,$db))) {
				showerror();
			}
		}
		
		$_SESSION["user_id"] = $row["id"];
		$_SESSION["user_name"] = $row["name"];
		
		header("Location: index.php");
	}
}
?>
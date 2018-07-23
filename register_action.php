<?php
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['password'];
$repassword = $_GET['repassword'];

if($db) {
	
	// criar query numa string
	$query  = "SELECT * FROM users WHERE email = '" . $email . "'";
	
	// executar a query
	if(!($result = @ mysql_query($query,$db)))
		showerror();
	
	$nrows  = mysql_num_rows($result);
	
	$error = -1;
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		//$error = "o email não é valido";
		$error = 1;
	} else if($nrows > 0) {
		//$error = "O email já existe na base de dados";
		$error = 2;
	} else if ($password != $repassword){
		//$error = "a repetição da password não coincide";
		$error = 3;
	}
	
	if (error != -1)
		header("Location:register.php?error=" . $error . "&name=" . $name . "&email=" . $email);
	else {
		header("Location: register_success.html");
	}
}
?>
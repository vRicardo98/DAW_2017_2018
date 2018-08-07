<?php
require_once('inc/init.php');
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$email = $_POST['email'];

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
		$_SESSION["error"] = 1;
	} else
		unset($_SESSION["error"]);
	
	if ($error)
		header("Location:password_reset.php");
	else {
		
		$reset_digest = substr(md5(time()),0,32);
		//$reset_sent_at = time();
		
		$query  = "UPDATE users SET reset_digest = '" . $reset_digest . "', reset_sent_at = CURDATE() WHERE id = '" . $row["id"] . "'";
				
		// executar a query
		if(!($result = @ mysql_query($query,$db))) {
			showerror();
		} else {
			//SEND EMAIL
			$to = $row["email"];
			$subject = "Password reset";
			$txt = "Olá Sr.(a) " . $row['name'] . "\n
					Para obter uma nova password clique no link\n"
					. "http://" . $_SERVER['HTTP_HOST'] . "/DAW/Lab8/new_password.php?token=" . $reset_digest . "\n
					Este link tem a validade de uma hora.\n
					Se NÃO pediu uma nova password IGNORE este email.\n\n\n
					Cumprimentos,\n\n
					webmaster!\n
					Página Web:\t http://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] . "\n
					E-mail:\t a12345@deei.fct.ualg.pt\n\n
					NOTA: Não responda a este email, não vai obter resposta!";
					
			$headers = "From: fabio.felicidade@sapo.pt" . "\r\n";
			//. "CC: somebodyelse@example.com";

			if(!mail($to,$subject,$txt,$headers))
				header("Location: message.php?code=0");
		}
		
		header("Location: message.php?code=1");
	}
}
?>
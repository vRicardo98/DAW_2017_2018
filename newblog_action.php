<?php
require_once('inc/init.php');
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$user_id = $_SESSION["user_id"];
$blog_text = $_POST['blog-text'];

if($db) {
	
	$query  = "INSERT INTO microposts (content, user_id, created_at, updated_at) VALUES ('" . $blog_text . "', '" . $user_id . "', CURDATE(), CURDATE())";
		
	// executar a query
	if(!($result = @ mysql_query($query,$db))) {
		showerror();
	} else
		header("Location: index.php");
}
?>
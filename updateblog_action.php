<?php
require_once('inc/init.php');
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$user_id = $_SESSION["user_id"];
$blog_id = $_GET['id'];
$blog_text = $_POST['blog-text'];

if($db) {
	
	$query  = "UPDATE microposts SET content = '" . $blog_text . "', updated_at = CURDATE() WHERE id = '" . $blog_id . "'";
		
	// executar a query
	if(!($result = @ mysql_query($query,$db))) {
		showerror();
	} else
		header("Location: index.php");
}
?>
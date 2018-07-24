<?php
require_once('inc/init.php');
require_once "inc/IT.php";
require_once 'db.php';

// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

if($db) {
	
	// criar query numa string
	$query  = "SELECT users.name AS username, microposts.* FROM microposts, users WHERE microposts.user_id = users.id";

	// executar a query
	if(!($result = @ mysql_query($query,$db)))
		showerror();

	// Cria um novo objecto template
	$template = new HTML_Template_IT('.');

	// Carrega o template Filmes2_TemplateIT.html
	$template->loadTemplatefile('index_template.html', true, true);

	//MENU
	$template->setCurrentBlock("MENU");

	$login_link = '<a href="./login.php">login</a>';
	$logout_link = '<a href="./logout_action.php">logout</a>';
	
	$register_link = '<a href="./register.php">register</a>';
	$blog_link = '<a href="./blog.php">post blog</a>';
	
	$template->setVariable('MENU_1', "home");
	$template->setVariable('MENU_2', isset($_SESSION["user_id"]) ? $logout_link : $login_link);
	$template->setVariable('MENU_3', isset($_SESSION["user_id"]) ? $blog_link : $register_link);
	$template->setVariable('WELCOME', isset($_SESSION["user_id"]) ? "Welcome, " . $_SESSION["user_name"] : null);
	
	// Faz o parse do bloco MENU
	$template->parseCurrentBlock();
	
	// mostra o resultado da query utilizando o template

	$nrows  = mysql_num_rows($result);
	
	for($i=0; $i < $nrows; $i++) {
		$tuple = mysql_fetch_array($result,MYSQL_ASSOC);

		// trabalha com o bloco MICROPOSTS do template
		$template->setCurrentBlock("MICROPOSTS");

		$update_link = isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $tuple["user_id"] ? '<a href="./blog.php?micropost_id=' . $tuple['id'] . '">update</a>' : null;
		
		$template->setVariable('UPDATE', $update_link);
		$template->setVariable('MICROPOST', $tuple['content']);
		$template->setVariable('USER', $tuple['username']);
		$template->setVariable('CREATED', $tuple['created_at']);
		$template->setVariable('UPDATED', $tuple['updated_at']);
		
		// Faz o parse do bloco MICROPOSTS
		$template->parseCurrentBlock();

	} // end for

	$template->show();
	
	// fechar a ligação à base de dados
	mysql_close($db);
} // end if 

?>

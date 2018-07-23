<?php

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

	$template->setVariable('MENU_1', "home");
	$template->setVariable('MENU_2', "login");
	$template->setVariable('MENU_3', "register");
	$template->setVariable('WELCOME', "Welcome Dude!");
	
	// Faz o parse do bloco MENU
	$template->parseCurrentBlock();
	
	// mostra o resultado da query utilizando o template

	$nrows  = mysql_num_rows($result);
	
	for($i=0; $i < $nrows; $i++) {
		$tuple = mysql_fetch_array($result,MYSQL_ASSOC);

		// trabalha com o bloco MICROPOSTS do template
		$template->setCurrentBlock("MICROPOSTS");

		$template->setVariable('UPDATE', '<a href="./post/update/' . $tuple['id'] . '">update</a>');
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

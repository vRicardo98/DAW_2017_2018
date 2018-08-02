<?php
require_once('inc/init.php');
require_once "inc/IT.php";
require_once 'db.php';

$blog_text = '';
$action = "newblog_action.php";

if(isset($_GET["micropost_id"])) {
	// ligação à base de dados
	$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

	if($db) {
		
		// criar query numa string
		$query  = "SELECT * FROM microposts WHERE microposts.id = '" . $_GET["micropost_id"] . "'";

		// executar a query
		if(!($result = @ mysql_query($query,$db)))
			showerror();
		
		$nrows  = mysql_num_rows($result);
		$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
		
		if($nrows > 0) {
			$blog_text = $tuple['content'];
			$action = "updateblog_action.php?id=" . $tuple['id'];
		}
	}
}

// Cria um novo objecto template
$template = new HTML_Template_IT('.');

// Carrega o template Filmes2_TemplateIT.html
$template->loadTemplatefile('blog_template.html', true, true);

//MENU	
$template->setCurrentBlock("MENU");
$template->setVariable('MENU_1', "home");
$template->setVariable('MENU_2', '<a href="./blog.php">blog</a>');
$template->parseCurrentBlock();
//FORM
$template->setCurrentBlock("FORM");
$template->setVariable('ACTION', $action);
$template->setVariable('BLOG', $blog_text);
$template->parseCurrentBlock();
// Faz o parse do bloco MENU
$template->parseCurrentBlock();
$template->show();
?>
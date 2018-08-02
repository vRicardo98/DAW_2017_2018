<?php
require_once('inc/init.php');

if(isset($_SESSION["user_id"])) {
	header("Location: index.php");
	exit();
}


require_once "inc/IT.php";
//require_once 'db.php';

// Cria um novo objecto template
$template = new HTML_Template_IT('.');

// Carrega o template Filmes2_TemplateIT.html
$template->loadTemplatefile('password_reset_template.html', true, true);

//MENU
$template->setCurrentBlock("MENU");

$login_link = '<a href="./login.php">login</a>';
$register_link = '<a href="./register.php">register</a>';

$template->setVariable('MENU_1', "home");
$template->setVariable('MENU_2', $login_link);
$template->setVariable('MENU_3', $register_link);

// Faz o parse do bloco MENU
$template->parseCurrentBlock();

$error = isset($_GET['error']) ? $_GET['error'] : '';

$template->setCurrentBlock("FORM-MESSAGE");
if($error){
	switch($error) {
		case '1'	:	$error = "o username/e-mail não é valido";
						break;
						
		case '2'	:	$error = "a password não é valida";
						break;
	}
	
	$template->setVariable('MESSAGE', '<div class="form-message">' . $error . '</div>');
}
$template->parseCurrentBlock();

$template->show();
?>
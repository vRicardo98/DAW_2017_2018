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
$template->loadTemplatefile('login_template.html', true, true);

//MENU
$template->setCurrentBlock("MENU");

$login_link = '<a href="./login.php">login</a>';
$logout_link = '<a href="./logout_action.php">logout</a>';

$register_link = '<a href="./register.php">register</a>';
$blog_link = '<a href="./blog.php">post blog</a>';

$template->setVariable('MENU_1', "home");
$template->setVariable('MENU_2', isset($_SESSION["user_id"]) ? $logout_link : $login_link);
$template->setVariable('MENU_3', isset($_SESSION["user_id"]) ? $blog_link : $register_link);
//$template->setVariable('WELCOME', isset($_SESSION["user_id"]) ? "Welcome, " . $_SESSION["user_name"] : null);

// Faz o parse do bloco MENU
$template->parseCurrentBlock();

//REGISTER
$email = isset($_GET['email']) ? $_GET['email'] : '';
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

$template->setCurrentBlock("FORM-LOGIN");
$template->setVariable('EMAIL', $email);
// Faz o parse do bloco MENU
$template->parseCurrentBlock();

$template->show();
?>
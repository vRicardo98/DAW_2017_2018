<?php
require_once('inc/init.php');

require_once "inc/IT.php";
//require_once 'db.php';

// Cria um novo objecto template
$template = new HTML_Template_IT('.');

// Carrega o template Filmes2_TemplateIT.html
$template->loadTemplatefile('message_template.html', true, true);

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
$code = isset($_GET['code']) ? $_GET['code'] : '';

$template->setCurrentBlock("MAIN");
if($code){
	switch($code) {
		case '1'	:	$code = "Password reset activated! <br> Email sent to you :-)";
						break;
						
		case '2'	:	$code = "Error: e-mail with your reset password link was not sent. Please, try again later.";
						break;
	}
	
	$template->setVariable('MESSAGE', '<div>' . $code . '</div>');
}
$template->parseCurrentBlock();

$template->show();
?>
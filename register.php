<?php

require_once "inc/IT.php";
//require_once 'db.php';

// Cria um novo objecto template
$template = new HTML_Template_IT('.');

// Carrega o template Filmes2_TemplateIT.html
$template->loadTemplatefile('register_template.html', true, true);

//MENU
$template->setCurrentBlock("MENU");

$template->setVariable('MENU_1', "home");
$template->setVariable('MENU_2', "login");
$template->setVariable('MENU_3', "register");
$template->setVariable('WELCOME', "Welcome Dude!");

// Faz o parse do bloco MENU
$template->parseCurrentBlock();

//REGISTER
$name = isset($_GET['name']) ? $_GET['name'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

$template->setCurrentBlock("FORM-MESSAGE");
if($error){
	switch($error) {
		case '1'	:	$error = "o email não é valido";
						break;
						
		case '2'	:	$error = "O email já existe na base de dados";
						break;
						
		case '3'	:	$error = "a repetição da password não coincide";
						break;
						
		default		: 	$error = -1;
		
	}
	
	$template->setVariable('MESSAGE', $error);
}
$template->parseCurrentBlock();

$template->setCurrentBlock("FORM-REGISTER");
$template->setVariable('NAME', $name);
$template->setVariable('EMAIL', $email);
// Faz o parse do bloco MENU
$template->parseCurrentBlock();

$template->show();
?>

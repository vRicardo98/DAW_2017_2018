<?php
session_start();
unset($_SESSION);
session_destroy();
setcookie("user_id", null, time() - 3600);

require_once "inc/IT.php";
//require_once 'db.php';

// Cria um novo objecto template
$template = new HTML_Template_IT('.');

// Carrega o template Filmes2_TemplateIT.html
$template->loadTemplatefile('message_template.html', true, true);

//MENU
$template->setCurrentBlock("MAIN");
$template->setVariable('MESSAGE', "See you back soon!");
// Faz o parse do bloco MENU
$template->parseCurrentBlock();
$template->show();
?>
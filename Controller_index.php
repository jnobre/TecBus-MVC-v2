<?php

require('Model/index.class.php'); //faz include da class
$view = new Template(); //instancia o Layout engine por assim dizer (instancia a class)
$view->title = "Inicio"; //define as variaveis que vao estar presentes nos ficheiros view/template
$view->pagina = "Index";
$view->titulos = array("Actualiza&ccedil;&otilde;es","Avisos","Avisos Gerais");
$texto1 = "Aplica&ccedil;&atilde;o Web que t&ecirc;m como objectivo facilitar o utilizador comum a mover-se de forma inteligente. D&uacute;vidas sobre a melhor rota entre dois pontos, quais as empresas poss&iacute;veis de transporte em determinado caso, esta aplica&ccedil;&atilde;o serve como tal para facilitar unificando a informa&ccedil;&atilde;o sobre mobilidade. At&eacute; ao momento s&oacute; forncemos dados da empresa de Coimbra SMTUC, com ajuda da plataforma TICE Mobilidade, que nos fornece os dados que ilustramos ao longo da aplica&ccedil;&atilde;o sobre a empresa SMTUC."; 
$view->links = array("Nova Actualiza&ccedil;&atilde;o Tecbus! ;) ","Rota 34 est&aacute; de ferias..","Qualquer coisa... para encher");
$view->body = $texto1;
$view->content = $view->render("View/index_home.php"); //renderiza a view respectiva do tipo de pagina
echo $view->render("View/main_template.php"); //renderiza a master view, e mostra o resultado no browser

?>
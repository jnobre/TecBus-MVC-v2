<?php
require('Model/index.class.php'); //faz include da class
$view = new Template(); //instancia o Layout engine por assim dizer (instancia a class)
$view->pagina = "Controller_Busca"; //pagina de actual 
$view->title = "Procurar Rota"; //define as variaveis que vao estar presentes nos ficheiros view/template
$texto1 = "Escolha o Autocarro pretendido:"; 
$view->body = $texto1;
$view->content = $view->render("View/BuscaRota.php"); //renderiza a view respectiva do tipo de pagina
echo $view->render("View/main_template.php"); //renderiza a master view, e mostra o resultado no browser
?>
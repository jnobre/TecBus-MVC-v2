<?php
require('Model/index.class.php'); //faz include da class
$view = new Template(); //instancia o Layout engine por assim dizer (instancia a class)
$view->pagina = "Controller_Pesquisar"; // pagina actual 
$view->title = "Pesquisa Avan&ccedil;ado"; //define as variavis que vao estar presentes nos ficheiros view/template
$view->content = $view->render("View/Pesquisa.php"); //renderiza a view respectiva do tipo de pagina
echo $view->render("View/main_template.php"); //renderiza a master view, e mostra o resultado no browser
?>
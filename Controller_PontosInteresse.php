<?php
	require('API/api.php');
	require('API/ost.php');
	require('Model/index.class.php'); //faz include da class
	$view = new Template(); //instancia o Layout engine por assim dizer (instancia a class)
	$view->pagina = "Controller_PontosInteresse"; // pagina em que estamos
	$view->title = "Pontos de Interesse da Aplica&ccedil;&atilde;o"; //define as variaveis que vao estar presentes nos ficheiros view/template
	$texto1 = "Escolha o Autocarro pretendido:"; 
	$view->body = $texto1;
	$agency=retornaid("Servi%C3%A7os+Municipalizados+de+Transportes+Urbanos+de+Coimbra");

	//Codigo para ver todas as rotas dinamicamente
	$offset=0;
	$paragens=array();
	$id=array();
	$j=0;
	while($offset!=-1)
	{
		$json_output=getbusesinagency($agency,$offset);
		for($i=0;$i<$json_output['Meta']['paginated_objects'];$i++)
		{
			array_push($paragens, array('paragem' => $json_output['Objects'][$i]['route_short_name'],'id_stop' => $json_output['Objects'][$i]['id']));
			$j++;
		}
										
		if($json_output['Meta']['paginated_objects']==25)
		{
			$offset=$offset+25;
		}
		else
		{
			$offset=-1;
		}
	}


	$aux = array();
	$view->tamanho = $j;		
	usort($paragens, 'cmp');
	for($i=0;$i<$j;$i++)
	{	
			array_push($aux,"<option value='".$paragens[$i]['id_stop'] . "&" . $paragens[$i]['paragem'] . "&" . "-1"."'>".$paragens[$i]['paragem']. "</option>");
	}

	$view->option_html = $aux;
	/*
	$view->option_html = "<option value=".$paragens[0]['id_stop'].">".$paragens[0]['paragem']."<option>";
	$view->option_html += "<option value=".$paragens[1]['id_stop'].">".$paragens[1]['paragem']."<option>";
	*/

	$view->content = $view->render("View/PontosInteresse.php"); //renderiza a view respectiva do tipo de pagina
	echo $view->render("View/main_template.php"); //renderiza a master view, e mostra o resultado no browser

?>
<?php
session_start();

include("api.php");
include("ost.php");

//Buscar id
/*$json_output = array();
$jsonurl="https://api.ost.pt/agencies/?name=Servi%C3%A7os+Municipalizados+de+Transportes+Urbanos+de+Coimbra&key=zjEIPEXmcpAmkkUIcLGlvgawBMnzrXryJKicaMoq";
$json=file_get_contents($jsonurl,0,null,null);
$json_output=json_decode($json,true);
$agency=$json_output['Objects'][0]['id'];*/
$agency=retornaid("Servi%C3%A7os+Municipalizados+de+Transportes+Urbanos+de+Coimbra");
echo("AGENCIA = " . $agency);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TecBUS</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
	<link href="css/estilo.css" rel="stylesheet" media="screen">
	<link rel="shortcut icon" href="http://tecbus.eu/IMAGES/logo.png">
  </head>
<body>

    <!-- NAVBAR
    ================================================== -->
    <div class="navbar-wrapper">
      <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
      <div class="container">

        <div class="navbar navbar-inverse">
          <div class="navbar-inner">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#"><img class="logo" src="http://tecbus.eu/IMAGES/logo.png"/>TecBUS</a>
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse collapse">
				<?php
				if($_SESSION['logado']==1)
				{?>
				<p class="navbar-text pull-right">Conectado <a href="#" class="navbar-link">Sair</a></p>
				<?php
				}
				else
				{
				?>
					<p class="navbar-text pull-right">N&atilde;o Conectado <a href="login.php" class="navbar-link">Login</a></p>
				<?php
				}
				?>
              <ul class="nav">
                <li><a href="index_home.php">Home</a></li>
                <li><a href="announcements.php?page=1">Avisos</a></li>
                <li class="active"><a href="rotas.php">Rotas</a></li>
				<li><a href="comochegara.php">Como Chegar a</a></li>
				<li><a href="sugestoes.php">Sugest&otilde;es</a></li>
              </ul>
			  
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

      </div> <!-- /.container -->
    </div><!-- /.navbar-wrapper -->



    <!-- Main
    ================================================== -->
	<section id="main">

	</section>
	
	<!-- /.carousel -->
	<section id="cabecalho">
		<div class="container">
		  <div class="row">
			<div class="span12">
				<h1 class="section-header">Rotas</h1>
			</div>
		  </div>
		</div>
	</section>

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
	<div class="container marketing">
		<br><br>
		<div align="center">
		<fieldset style="width: 610px;">
		<form method="post" action="listarotav2.0.php" name="rotas">
		<?php
				$status_server=status($agency);
		
				if ($status_server < 200 || ($status_server > 300 && $status_server != 302)) { 

					switch ($status_server) {         
						case 301: $error = "301 Moved Permanently"; break;       
						case 400: $error = "400 Bad Request"; break;        
						case 401: $error = "401 Unauthorized"; break;        
						case 403: $error = "403 Forbidden"; break;         
						case 404: $error = "404 Not Found"; break;        
						case 408: $error = "408 Request Timeout"; break;         
						case 500: $error = "500 Internal Server Error"; break;       
						case 503: $error = "503 Service Unavailable"; break;         
						default: $error = "$status_server - Servidor Offline";    
					}
					
					echo($error."<br> <b>Pedimos desculpa pelo inc&ocirc;modo <br> Obrigado pela compreens&atilde;o!</b>");
				}else{
			?>
				Rota:
				<select name="rotas">
				
				<?php
			
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
				
				usort($paragens, 'cmp');
				for($i=0;$i<$j;$i++)
				{	
					//echo("route == ".$paragens[$i]['id_stop']);
					if($_POST['rotas'])
					{
						$pieces = explode("&", $_POST['rotas']);
						if($pieces[1]==$paragens[$i]['paragem'])
						{
							?>
							<option value=<?php echo($paragens[$i]['id_stop'] . "&" . $paragens[$i]['paragem'] . "&" . "-1");?> selected = "selected"><? echo($paragens[$i]['paragem']); ?></option>
							<?php	
						}
						else
						{
							?>
							<option value=<?php echo($paragens[$i]['id_stop'] . "&" . $paragens[$i]['paragem'] . "&" . "-1");?>><? echo($paragens[$i]['paragem']); ?></option>
							<?php	
						}
					
					}
					else
					{
						?>
						<option value=<?php echo($paragens[$i]['id_stop'] . "&" . $paragens[$i]['paragem'] . "&" . "-1");?>><? echo($paragens[$i]['paragem']); ?></option>
						<?php					
					}

				}

				?>
				
				</select>
				<input type="submit" name="submeter" value="Ver">
		</form>	
		</fieldset>
		<!--<p><b>Nota:</b> Cada marcador representa uma paragem do autocarro selecionado &aacute; excepção do marcador "Guarda Inglesa - Esta&ccedil;&atilde;o de Recolha"</p>-->
		</div>
		 
		<?php 

		if($_POST['rotas'])
		{
			/*mysql_connect("localhost", "tecbuseu_tecbus" , "q0QqS2t6rkrn") or die(mysql_error());
			mysql_select_db("tecbuseu_TECBUS") or die(mysql_error());
			$query= "UPDATE visitas SET rotas=rotas+1 WHERE ID=1";
			mysql_query($query) or die(mysql_error());	*/
			//Mostrar mapa
			
			/*<--------------------recolher as trips de uma determinada rota---------------->*/
			$trips=array();
			$stops=array();
			$j=0;
			$offset=0;
			$contador=0;
			$pieces = explode("&", $_POST['rotas']);	
			//echo("01 piece == ".$pieces[0]." 02 == ".$pieces[1]." 03 == ". $pieces[2]."<br>");
			/*procura trip se ja nao tiver procurado*/
			
			while($offset!=-1)
			{		
			
					$json_output=gettrips($pieces[0],$offset);
					for($i=0;$i<$json_output['Meta']['paginated_objects'];$i++)
					{
						array_push($trips, array('Nome_viagem' => $json_output['Objects'][$i]['trip_short_name'],'id_trip' => $json_output['Objects'][$i]['trips']));
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
				
			?><div align="center"> <fieldset style="width: 610px;"> <form method="post" action="listarotav2.0.php" name="rotas"> 
			Viagem:
				<?php 
				
				for($i=0;$i<$j;$i++)
				{	
					echo("Trip == ".$trips[$i]['id_trip'][0]. " <==> ".$trips[$i]['Nome_viagem']." <br>");
				}
				?>
			<select name="rotas"><?php
			for($i=0;$i<$j;$i++)
			{	
			
				if($pieces[2] == $trips[$i]['id_trip'][0])
				{
						?>
						<option value=<?php echo($pieces[0]. "&" . $pieces[1] . "&" .$trips[0]['id_trip'][$i]);?> selected = "selected"><? echo($trips[$i]['Nome_viagem']); ?></option>
						<?php				
				}
				else
				{
					?>
					<option value=<?php echo($pieces[0] . "&" . $pieces[1] . "&" .$trips[0]['id_trip'][$i]);?>><? echo($trips[$i]['Nome_viagem']); ?></option>
					<?php					
				}

			}
			?> </select>
			<input type="submit" name="submeter" value="Ver Trip"></form></fieldset></div><?php
			//echo("03<br>");

			echo("04 piece 2 == ".$pieces[2]."<br>");
			if($pieces[2]==-1)
			{
				$pieces[2]=$trips[0]['id_trip'][0];		
			}
			
			$stops=array();
			$offset=0;
			$contador=0;
			$j=0;
			while($offset!=-1)
			{				
				$json_output = array();
				echo("Trip == " . $pieces[2] . " Route == ".$pieces[0]);
				
				$json_output=gettrip($pieces[2],$pieces[0],$agency,$offset);
				
				for($i=0;$i<$json_output['Meta']['paginated_objects'];$i++)
				{
					//echo($contador . "<br>");
					if($json_output['Objects'][$i]['id']==6838)
					{
						
					}
					else
					{
						$descricao[$contador]=$json_output['Objects'][$i]['stop_name'];
						//echo("Descrição da Paragem:" . $json_output['Objects'][$i]['stop_desc']);
						$coordenadas[$contador][0]=$json_output['Objects'][$i]['point']['coordinates'][1];
						$coordenadas[$contador][1]=$json_output['Objects'][$i]['point']['coordinates'][0];
						$contador++;
					}
					
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
			?>
			<div align="center">
			
			<?php
			echo("Est&aacute; a ver as paragens do autocarro n&uacute;mero " . $pieces[1]);		
			showmap($coordenadas,$descricao,$contador);
			?>
			</div>
			<br>
			<br>
			<?php
			
		}
		?>

		<!--</div>-->

		<?php
		}


		?> 
		
	<!-- FOOTER -->
      <footer>
	  <hr>
	  <p class="pull-right"><i class="icon-user"></i> design by <a href="http://andrepcg.me">andrepcg</a></p>
        <p><strong>TecBUS</strong> - TICE.Mobilidade @ Universidade de Coimbra</p>
		<p><i class="icon-briefcase"></i> by Andr&eacute; Dinis, Bruno Rolo, Jo&atilde;o Nobre</p>
		
      </footer>

    </div><!-- /.container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  

</body>
</html>
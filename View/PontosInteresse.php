<br>

<div align="center">
	<h4><?php echo $body; ?></h4>
	<select name="rotas">
		<?php 
			for($i = 0; $i < $tamanho; $i++)
			{
		 		echo($option_html[$i]); 
			}
		 ?>
		<!-- <option value="teste">Teste</option> -->
	</select>
</div>
<div id="Ponto_interesse" align="center">
	DIV do Google Maps
</div>
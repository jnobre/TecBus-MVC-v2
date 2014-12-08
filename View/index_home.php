<?php for($i = 0; $i < 3; $i++){ 
	if($i < 2){
	?> <div class="span4"><?php
	}else{
	?> <div class="span3">
	<?php }?>
<h2><?php echo $titulos[$i]; ?></h2>
<p><?php echo $links[$i]; ?></p>

</div>
<?php } ?>
<br>

<div class = "span10">

<h2>Sobre</h2>
<p><?php echo  $body ?></p>

</div>
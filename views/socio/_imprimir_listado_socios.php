<center><h1>Listado de Socios <?php echo $estado?></h1></center>

<h3>Debito: <?= $debito->concepto ?></h3>

<table border="1" width="700px">

<tr>
	<th align="center">Matricula</th>	
	<th align="center">Nombre</th>
	<th align="center">DNI</th>	
	<th align="center">Fecha de Nacimiento</th>	
</tr>

<?php foreach ($socio as $s) {?>	

	<tr>			

		<td align="center"><?= $s->matricula ?></td>
	
		<td align="center"><?= $s->apellido_nombre ?></td> 
	
		<td align="center"><?= $s->dni ?></td>

		<td align="center">
			<?php
				 if ($s->fecha_nacimiento!=""){
				 	echo date("d-m-Y",strtotime($s->fecha_nacimiento));
				 }

		 	?>		 		
	 	</td>

	</tr>

<?php } ?>

</table>



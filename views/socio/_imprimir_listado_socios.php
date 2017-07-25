<style type="text/css"> 
	th,td,b,p {
 		font-size: 10px;
 	}
</style>

<center><h1>Padron de Socios <?php echo $estado?></h1></center>

<h3>Debito: <?= $debito->concepto ?></h3>

<table border="1">

<tr>
	<th align="center">Matricula</th>	
	<th align="center">Nombre</th>
	<th align="center">DNI</th>	
	<th align="center">Fecha Nac.</th>
	<th align="center">Mail</th>
	<th align="center">Domicilio</th>	
	<th align="center">Provincia</th>
	<th align="center">Ciudad</th>
	<th align="center">CP</th>		
	<th align="center">Tel</th>
	<th align="center">Cel</th>
	<th align="center">Categoria</th>
	<th align="center">Estado</th>	
</tr>

<?php foreach ($socio as $s) {?>	

	<tr>			

		<td align="center"><?= $s->matricula ?></td>	
		<td align="left"><?= $s->apellido_nombre ?></td> 	
		<td align="center"><?= $s->dni ?></td>
		<td align="center">
			<?php
				 if ($s->fecha_nacimiento!=""){
				 	echo date("d-m-Y",strtotime($s->fecha_nacimiento));
				 }
		 	?>		 		
	 	</td>
	 	<td align="center"><?= $s->email ?></td>
	 	<td align="center"><?= $s->direccion ?></td>
	 	<td align="center"><?= $s->provincia->descripcion ?></td>
	 	<td align="center"><?= $s->ciudad->descripcion ?></td>
	 	<td align="center"><?= $s->cp ?></td>
	 	<td align="center"><?= $s->telefono2 ?></td>
	 	<td align="center"><?= $s->telefono ?></td>
	 	<td align="center"><?= $s->categoriaSocial->descripcion ?></td>
	 	<td align="center"><?= $estado ?></td>


	</tr>

<?php } ?>

</table>



<div>
	<h1>Libro de Socios</h1>
	<label>Categoria desde: <?=$categoria_desde?> Hasta: <?=$categoria_hasta?></label>
	<label>Periodo: <?=$anio?></label>
</div>
<hr>

<table border="1" width="100%">

<tr>
	<th align="center">N°</th>
	<th align="center">Socio</th>
	<th align="center">Categoria</th>
	<th align="center">Ene</th>
	<th align="center">Feb</th>
	<th align="center">Mar</th>
	<th align="center">Abr</th>
	<th align="center">May</th>
	<th align="center">Jun</th>
	<th align="center">Jul</th>
	<th align="center">Ago</th>
	<th align="center">Sep</th>
	<th align="center">Oct</th>
	<th align="center">Nov</th>
	<th align="center">Dic</th>
</tr>
<?php $e = 1; ?>
<?php foreach ($socio as $s) {?>	
	<tr>
	
		<?php 
			$i = 0;
			$ene="";
			$feb="";
			$mar="";
			$abr="";
			$may="";
			$jun="";
			$jul="";
			$ago="";
			$sep="";
			$oct="";
			$nov="";
			$dic=""
		?>

	<?php foreach ($movimientoDetalle as $md) {?>
					
			<?php if ($md->movimiento->fk_cliente == $s->id){ ?>
				
				<?php if ($i == 0){ $i++; ?>
					<td align="center"><?= $e++ ?></td>
					<td align="center"><?= strtoupper($s->apellido_nombre)?></td> 		
					<td align="center"><?=$md->subCuenta->concepto ?></td>
				<?php } ?>
				<?php 				
					switch ($md->periodo_mes) {
						case '1':							
							$ene = number_format($md->importe,2,",",".");
							break;
						case '2':							
							$feb = number_format($md->importe,2,",",".");
							break;
						case '3':						
							$mar = number_format($md->importe,2,",",".");
							break;
						case '4':
							$abr = number_format($md->importe,2,",",".");
							break;
						case '5':
							$may = number_format($md->importe,2,",",".");
							break;
						case '6':
							$jun = number_format($md->importe,2,",",".");
							break;
						case '7':
							$jul = number_format($md->importe,2,",",".");
							break;
						case '8':
							$ago = number_format($md->importe,2,",",".");
							break;
						case '9':
							$sep = number_format($md->importe,2,",",".");
							break;
						case '10':
							$oct = number_format($md->importe,2,",",".");
							break;
						case '11':
							$nov = number_format($md->importe,2,",",".");
							break;
						case '12':
							$dic = number_format($md->importe,2,",",".");
							break;
						default:
							# code...
							break;
					}
				?>	

			<?php  } ?>
	<?php } ?>
	<?php if ($i == 1){ ?>
		<td><?=$ene?></td><td><?=$feb?></td><td><?=$mar?></td><td><?=$abr?></td><td><?=$may?></td><td><?=$jun?></td><td><?=$jul?></td><td><?=$ago?></td><td><?=$sep?></td><td><?=$oct?></td><td><?=$nov?></td><td><?=$dic?></td>
	<?php } ?>
	</tr>
<?php } ?>
</table>
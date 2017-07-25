<style type="text/css"> 
th,td,b,p {
 		font-size: 10px;
 	}
</style>
<div>
	<h1>Movimientos de Caja</h1><label>Fecha desde: <?=date("d-m-Y", strtotime($fecha_desde)) . " hasta " . date("d-m-Y", strtotime($fecha_hasta))?></label>
</div>
<hr>

<br>

<table border="1">

<tr>
	<th>Fecha</th>
	<th>Nro Rec.</th>	
	<th>R.Social</th>
	<th>Conc.</th>
	<th>Per.</th>		
	<th>Ing.</th>
	<th>Egre.</th>
	<th>Saldo</th>
</tr>

<?php foreach ($movimiento as $m) {?>

	<?php foreach ($m->movimientoDetalle as $md) {?>

		<tr>
			<td align="left"><?=date("d-m-Y", strtotime($m->fecha_pago))?></td>
			<td align="center"><?=$m->nro_recibo?></td>
			<?php if ($md->tipo == 'i') {?>			
				<?php $saldo = $md->importe + $saldo?>
				<?php $suma_ingreso = $md->importe + $suma_ingreso?>
				<td align="left">
					<?php if ($m->fk_cliente!=""){
						 	echo strtoupper($m->socio->apellido_nombre); 
						 }elseif ($m->cliente_id!="") {
						 	echo strtoupper($m->cliente->razon_social); 
						 } 
				 	?>					
				</td>				
			<?php } else{	?>
			<?php $saldo = $saldo - $md->importe?>
			<?php $suma_egreso = $md->importe + $suma_egreso?>
				<td align="left">
					<?php if ($m->fk_prov!=""){
						 	echo strtoupper($m->proveedor->nombre);
						 }; 
				 	?>
			 	</td>
			<?php } ?>
			<td align="center"><?=$md->subCuenta->concepto?></td>
			<td align="center"><?=$m->getPeriodo($m->id)?></td>
			<?php if ($md->tipo == 'i') {?>		
				<td align="right"><?="$" . number_format($md->importe,2,",",".") ?></td><td></td><td align="right"><?= "$" . number_format($saldo,2,",",".") ?></td>
			<?php } else{	?>
				<td></td><td align="right"><?="$" . number_format($md->importe,2,",",".") ?></td><td align="right"><?= "$" . number_format($saldo,2,",",".")?></td>
			<?php } ?>
		</tr>

	<?php }	?>


<?php }
?>

</table>

<p style="font-size:10px"><strong>CAJA INCIAL:</strong> $<?= number_format($caja_inicial,2,",",".") ?></p>
<p style="font-size:10px"> <strong>TOTAL INGRESO:</strong> $<?= number_format($suma_ingreso,2,",",".") ?></p>
<p style="font-size:10px"><strong>TOTAL EGRESO:</strong> $<?= number_format($suma_egreso,2,",",".") ?></p>
<p style="font-size:10px"><strong>CAJA FINAL:</strong> $<?= number_format($saldo+$caja_inicial,2,",",".") ?></p>


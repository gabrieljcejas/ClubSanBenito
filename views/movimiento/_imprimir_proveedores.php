<div>
	<h1>Detalle Egresos</h1>
	<label>Fechas: <?= date("d-m-Y",strtotime($fecha_desde)) . " - " . date("d-m-Y",strtotime($fecha_hasta))?></label>
</div>

<hr>

<br><br><br>

<table border="1" width="100%">

<tr><th>Fecha</th>
<th>Proveedor</th>
<th>Concepto</th>
<th>Importe</th></tr>

<?php foreach ($movimiento as $m) {?>	
	
	<?php foreach ($m->movimientoDetalle as $md) {?>
	
		<tr>
			<td align="center"><?= date("d-m-Y",strtotime($m->fecha_pago)) ?></td>
			<td align="center"><?=$m->proveedor->nombre?></td>
			<td align="center"><?=$md->subCuenta->concepto?></td>
			<?php $saldo = $md->importe + $saldo ?>
			<td align="right"><?= "$".$md->importe?></td>
		</tr>
	
	<?php }	?>

<?php } ?>

</table>

<br>

<b>SALDO: <?= "$".$saldo?></b>
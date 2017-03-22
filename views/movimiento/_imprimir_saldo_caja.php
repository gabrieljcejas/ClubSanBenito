<div><h1>Movimientos de Caja</h1><label>Fecha desde: <?=date("d-m-Y", strtotime($fecha_desde)) . " hasta " . date("d-m-Y", strtotime($fecha_hasta))?></label></div>
<hr>

<br><br><br>

<table border="1">

<tr>
	<th>Fecha</th>
	<th>Concepto</th>
	<th>Socio/Cliente</th>
	<th>Proveedor</th>	
	<th>Ingresos</th>
	<th>Egresos</th>
	<th>Saldo</th>
</tr>

<?php foreach ($movimiento as $m) {?>

	<?php foreach ($m->movimientoDetalle as $md) {?>

		<tr>
			<td align="center"><?=date("d-m-Y", strtotime($m->fecha_pago))?></td>
			<td align="center"><?=$md->subCuenta->concepto?></td>
			<?php if ($md->tipo == 'i') {?>			
				<?php $saldo = $md->importe + $saldo?>
				<td align="center"><?php if ($m->fk_cliente!=""){ echo $m->socio->apellido_nombre; } ?></td><td></td><td align="right"><?="$" . $md->importe?></td><td></td><td align="right"><?= "$".$saldo?></td>
			<?php } else{	?>
			<?php $saldo = $saldo - $md->importe?>
				<td></td><td align="center"><?php if ($m->fk_prov!=""){ echo $m->proveedor->nombre;}; ?></td><td></td><td align="right"><?="$" . $md->importe?></td><td align="right"><?= "$".$saldo?></td>
			<?php } ?>
		</tr>

	<?php }	?>

<?php }
?>

</table>

<br>

<p><strong>SALDO: $<?=$saldo?></strong></p>


<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
?>

<div>
	<h1>Balance</h1>
	<label>Fecha desde: <?=date("d-m-Y", strtotime($fecha_desde)) . " hasta " . date("d-m-Y", strtotime($fecha_hasta))?></label>
</div>
<hr>

<br><br>

<table border="1" width="100%" style="font-size:10px">
<tr>	
	<th>Conceptos</th>
	<th>Ingresos</th>
	<th>Gastos</th>	
	<th>Saldo</th>
</tr>
<?php $saldo = 0; ?>	


<?php foreach ($query as $md) {?>

	<tr>			
		<td align="center"><?=$md->subCuenta->concepto?></td>
			<?php if ($md->tipo == 'i') {?>			
				<?php $saldo = $md->importe + $saldo?>					
				<?php $suma_ingreso = $md->importe + $suma_ingreso?>
				<td align="right"><?="$" . number_format($md->importe,2,",",".")?></td><td></td><td align="right"><?= "$" . number_format($saldo,2,",",".") ?></td>
			<?php } else{	?>
				<?php $saldo = $saldo - $md->importe?>
				<?php $suma_egreso = $md->importe + $suma_egreso?>
		<td></td>			
		<td align="right"><?="$" .number_format($md->importe,2,",",".") ?></td><td align="right"><?= "$" . number_format($saldo,2,",",".") ?></td>
		<?php } ?>
	</tr>

<?php }	?>


?>

</table>

<br>

<p style="font-size:10px"><strong>TOTAL INGRESO:</strong> $<?= number_format($suma_ingreso,2,",",".") ?></p>
<p style="font-size:10px"><strong>TOTAL GASTOS:</strong> $<?= number_format($suma_egreso,2,",",".") ?></p>
<p style="font-size:10px"><strong>SALDO:</strong> $<?= number_format($saldo,2,",",".") ?></p>
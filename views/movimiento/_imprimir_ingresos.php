<style type="text/css"> 
th,td,b,p {
 		font-size: 10px;
 	}
</style>
<div><h1>Detalle Ingresos</h1><label>Fechas: <?=date("d-m-Y", strtotime($fecha_desde)) . " - " . date("d-m-Y", strtotime($fecha_hasta))?></label></div>
<hr>

<br><br><br>

<table border="1">

<tr>
	<th>Fecha</th>
	<th>Cliente</th>	
	<th>Concepto</th>
	<th>Importe</th>
</tr>

<?php foreach ($movimiento as $m) {?>

	<?php foreach ($m->movimientoDetalle as $md) {?>

		<tr>

			<?php if ($md->tipo == 'i') {?>
			<td align="center"><?=date("d-m-Y", strtotime($m->fecha_pago))?></td>
			<td align="center">				
				<?php 
					if ($m->socio->apellido_nombre!=""){
						echo  strtoupper($m->socio->apellido_nombre);
					}else{
						echo  strtoupper($m->cliente->razon_social);
					}
				?>
				
			</td>			
			<td align="center"><?=$md->subCuenta->concepto?></td>
				<?php $saldo = $md->importe + $saldo?>
				<td align="right"><?="$" . $md->importe?></td>
			<?php }
	?>

		</tr>

	<?php }
	?>

<?php }
?>

</table>

<br>

<b>SALDO: <?= "$".$saldo?></b>
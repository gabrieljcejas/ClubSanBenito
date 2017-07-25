<?php
use yii\grid\GridView;
?>

    <head>
        <link href="/club/web/assets/83b0ec3d/css/bootstrap.css" rel="stylesheet">
        <link href="/club/web/css/site.css" rel="stylesheet">
    </head>
    <style type="text/css"> 
	th,td,b,p {
 		font-size: 10px;
 	}
</style>
    
    <h1><?=$titulo?></h1>        
    <h3>Deporte:
    <?php 
		if ($dep->concepto!=""){
			echo $dep->concepto ;
		}else{
			echo "Todos";
		}
	?>
	</h3>		
    <!--<h3>Categoria: <?= $cat->descripcion ?></h3><br>-->
    <label>Fecha desde: <?= date("d-m-Y",strtotime($fecha_desde)) . " hasta " . date("d-m-Y",strtotime($fecha_hasta))?></label>
	

<hr><br><br>

<table border="1">

<tr>
	<th align="center">Socio</th>
	<th align="center">Categoria</th>
	<th align="center">Concepto</th>
	<th align="center">Periodo</th>	
	<th align="center">Fecha de Pago</th>
	<th align="center">Importe</th>
</tr>

<?php if ($ss!="") {?>

	<?php foreach ($movimientoDetalle as $md) {?>

			<tr>			
				<?php if ($ss == $md->movimiento->fk_cliente){ ?>

					<td align="left"><?=  strtoupper($socio->apellido_nombre) ?></td> 
					<td align="center"><?= date("Y",strtotime($socio->fecha_nacimiento)) ?></td>
					<td align="center"><?= $md->subCuenta->concepto ?></td>
					<td align="center"><?= $md->movimiento->getPeriodo($md->movimiento_id) ?></td>				
					<td align="center">
						<?php 
							if ($md->movimiento->fecha_pago!=""){
								echo date("d-m-Y",strtotime($md->movimiento->fecha_pago)) ;
								$saldo = $saldo - $md->importe;
							}else{
								echo "-";
							}
						?>		
						<?php $saldo = $md->importe + $saldo ?>
					</td>				
					<td align="right"><?= "$".$md->importe?></td>
				<?php } ?>	

			</tr>
		
	<?php }	?>

<?php }else{ ?>

	<?php foreach ($socio as $s) {?>	
		
		<?php foreach ($movimientoDetalle as $md) {?>

			<tr>			
				<?php if ($s->id == $md->movimiento->fk_cliente){ ?>

					<td align="left"><?=  strtoupper($s->apellido_nombre) ?></td> 
					<td align="center"><?= date("Y",strtotime($s->fecha_nacimiento)) ?></td>
					<td align="center"><?= $md->subCuenta->concepto ?></td>
					<td align="center"><?= $md->periodo_mes."-".$md->periodo_anio ?></td>				
					<td align="center">
						<?php 
							if ($md->movimiento->fecha_pago!=""){
								echo date("d-m-Y",strtotime($md->movimiento->fecha_pago)) ;
								$saldo = $saldo - $md->importe;
								$abonado = $md->importe + $abonado;
							}else{
								echo "-";
							}
						?>		
						<?php $saldo = $md->importe + $saldo ?>
					</td>				
					<td align="right"><?= "$".$md->importe?></td>
				<?php } ?>	

			</tr>
		
		<?php }	?>

	<?php } ?>

<?php } ?>

</table>


</table>

<br>

<b style="font-size:10px">TOTAL DEUDA: <?= "$".$saldo?></b><br><br>

<b style="font-size:10px">TOTAL ABONADO: <?= "$".$abonado?></b>


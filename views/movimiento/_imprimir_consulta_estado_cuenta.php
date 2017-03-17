<?php
use yii\grid\GridView;
?>

    <head>
        <link href="/club/web/assets/83b0ec3d/css/bootstrap.css" rel="stylesheet">
        <link href="/club/web/css/site.css" rel="stylesheet">
    </head>
    
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

<table border="1" width="700px">

<tr>
	<th align="center">Socios</th>
	<th align="center">Conceptos</th>
	<th align="center">Periodo</th>	
	<th align="center">Fecha de Pago</th>
	<th align="center">Importe</th>
</tr>

<?php if ($ss!="") {?>

	<?php foreach ($movimientoDetalle as $md) {?>

			<tr>			
				<?php if ($ss == $md->movimiento->fk_cliente){ ?>

					<td align="center"><?= $socio->apellido_nombre ?></td> 
					<td align="center"><?= $md->subCuenta->concepto ?></td>
					<td align="center"><?= $md->periodo_mes."-".$md->periodo_anio ?></td>				
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

					<td align="center"><?= $s->apellido_nombre ?></td> 
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

<b>TOTAL DEUDA: <?= "$".$saldo?></b><br><br>

<b>TOTAL ABONADO: <?= "$".$abonado?></b>


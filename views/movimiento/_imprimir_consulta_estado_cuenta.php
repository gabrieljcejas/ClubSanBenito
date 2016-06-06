<?php
use yii\grid\GridView;
?>

    <head>
        <link href="/club/web/assets/83b0ec3d/css/bootstrap.css" rel="stylesheet">
        <link href="/club/web/css/site.css" rel="stylesheet">
    </head>
    
    <h1>Estado de Cuenta <?=$titulo?></h1>    
    <h3>Deporte: <?= $dep->concepto ?></h3>
    <h3>Categoria: <?= $cat->descripcion ?></h3><br>
    <label>Fecha desde: <?= date("d-m-Y",strtotime($fecha_desde)) . " hasta " . date("d-m-Y",strtotime($fecha_hasta))?></label>
	

<hr><br><br>

<table border="1" width="700px">

<tr>
	<th align="center">Socio</th>
	<th align="center">Concepto</th>
	<th align="center">Mes</th>
	<th align="center">Año</th>
	<th align="center">Fecha</th>
	<th align="center">Importe Abonado</th>
</tr>

<?php foreach ($socio as $s) {?>	
	
	<?php foreach ($movimientoDetalle as $md) {?>

		<tr>			
			<?php if ($s->id == $md->movimiento->fk_cliente){ ?>

				<td align="center"><?= $s->apellido_nombre ?></td> 
				<td align="center"><?= $md->subCuenta->concepto ?></td>
				<td align="center"><?= $md->periodo_mes ?></td>
				<td align="center"><?= $md->periodo_anio ?></td>
				<td align="center">
					<?php 
						if ($md->movimiento->fecha_pago!=""){
							echo date("d-m-Y",strtotime($md->movimiento->fecha_pago)) ;
						}else{
							echo "-";
						}
					?>		
				</td>
				<?php $saldo = $md->importe + $saldo ?>
				<td align="right"><?= "$".$md->importe?></td>
			<?php } ?>	

		</tr>
	
	<?php }	?>

<?php } ?>

</table>


</table>

<br>

<b>SALDO: <?= "$".$saldo?></b>


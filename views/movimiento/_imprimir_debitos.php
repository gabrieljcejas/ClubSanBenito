<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//ini_set('memory_limit', '-1');


?><head>
<style>
@page{
margin-top: 0.5cm; usable in first page only
margin-right: 0.5cm;
margin-left: 0.5cm;
}
</style>
</head>
<?php $cant_recibos = 0;?>
<?php foreach ($movimiento as $m) {?>
        <?php $total = 0;?>
         <!-- codigo html tabla-->
                <table width="100%" border="1" bordercolor="#000000" style="font-size:10px">
                  <tr>
                    <td colspan="3" align="center" bgcolor="#0066FF"  style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
                    <td rowspan="2" align="center" bgcolor="#0066FF"  style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
                    <td width="1%" style="border:none">&nbsp;</td>
                    <td colspan="2" align="center" bgcolor="#0066FF"  style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
                    <td colspan="2" rowspan="2" align="center" bgcolor="#0066FF"  style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" bgcolor="#0066FF"  style="border:none"><strong>Fundado el 9 de julio de 1916.  Persona Juridica 2590</strong></td>
                    <td width="1%" style="border:none"></td>
                    <td colspan="2" align="center" bgcolor="#0066FF"  style="border:none"><strong>Fundado el 9 de julio de 1916.  Persona Juridica 2590</strong></td>
                  </tr>
                  <tr style="border:none">
                    <td >Socio Nº:</td>
                    <td  style="border:none"><strong>
                    <?=$m->fk_cliente?>
                    </strong></td>
                    <td>Recibo Nº:</td>
                    <td  style="border:none"><strong>
                    <?=$m->nro_recibo?>
                    </strong></td>
                    <td style="border:none"></td>
                    <td>Socio Nº:</td>
                    <td  style="border:none"><strong>
                    <?=$m->fk_cliente?>
                    </strong></td>
                    <td>Recibo Nº:</td>
                    <td  style="border:none"><strong>
                    <?=$m->nro_recibo?>
                    </strong></td>
                  </tr>
                  <tr>
                    <td>Apellido y Nombre:</td>
                    <td  style="border:none"><strong>
                    <?=$m->socio->apellido_nombre?>
                    </strong></td>
                    <td>Fecha:</td>
                    <td  style="border:none"><strong>
                    <?=$fecha?>
                    </strong></td>
                    <td style="border:none"></td>
                    <td>Apellido y Nombre:</td>
                    <td  style="border:none"><strong>
                    <?=$m->socio->apellido_nombre?>
                    </strong></td>
                    <td>Fecha:</td>
                    <td  style="border:none"><strong>
                    <?=$fecha?>
                    </strong></td>
                  </tr>
                  <tr>


        <?php $i = 0;?>

        <?php foreach ($movimiento_detalle as $md) {?>

            <?php if ($md->movimiento_id == $m->id) {?>
                <?php if ($i == 0) {?>
                <td>Domicilio:</td>
                    <td  style="border:none"><strong>
                    <?=$m->socio->direccion?>
                    </strong></td>
                    <td>Periodo:</td>
                    <td  style="border:none"><strong>
                    <?=$md->getMes($md->periodo_mes) . " " . $md->periodo_anio?>
                    </strong></td>
                    <td style="border:none">&nbsp;</td>
                    <td>Domicilio:</td>
                    <td  style="border:none"><strong>
                    <?=$m->socio->direccion?>
                    </strong></td>
                <td>Periodo:</td>
                    <td  style="border:none"><strong>
                    <?=$md->getMes($md->periodo_mes) . " " . $md->periodo_anio?>
                    </strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
                    <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
                    <td style="border:none">&nbsp;</td>
                    <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
                    <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
                  </tr>
                <?php }
	?>
                <?php $i++;?>
                <!-- codigo html itmens cuentas conceptos-->
                <tr>
                <td colspan="3" ><strong>
                <?=$md->subCuenta->concepto?>
                ..........</strong></td>
                <td align="center" ><strong>$
                <?=$md->importe?>
                </strong></td>
                <td style="border:none">&nbsp;</td>
                <td colspan="3" ><strong><?=$md->subCuenta->concepto?>..........<strong></td>
                <td align="center" ><strong>$ <?=$md->importe?></strong></td>
              </tr>

                <?php $total = $md->importe + $total;?>

            <?php }
	?>


        <?php } //end foreach?>
        <!-- codigo html parte de abajo-->
        <tr>            
            <td  style="border:none"><br><br><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
            <td align="center"  style="border:none"><br><br><p>...........................</p><p>Firma</p></td>
            <td style="border:none"><br><br><strong>TOTAL</strong></td>
            <td style="border:none" align="center"><strong><br><br><br>$
            <?=$total?>
            </strong></td>
            <td style="border:none">&nbsp;</td>
            <td  style="border:none"><br><br><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
            <td align="center"  style="border:none"><br><br><p>...........................</p><p>Firma</p></td>
            <td  style="border:none"><br><br><strong>TOTAL</strong></td>
            <td  style="border:none" align="center"><strong><br><br><br>$
            <?=$total?>
            </strong></td>
          </tr>
        </table><br>
        <?php $cant_recibos++;?>
        <?php if ($cant_recibos == 3) {?>
            <?php $cant_recibos = 0;?>
            <pagebreak />
        <?php }
	?>
    <?php }
?>


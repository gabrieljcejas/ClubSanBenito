<?php

//var_dump($modelDetalle);

?><head>
<style>
@page{
margin-top: 0.5cm; usable in first page only
margin-right: 0.0cm;
margin-left: 0.5cm;
}
</style>
</head>
      <!-- codigo html tabla-->
    <table border="1" bordercolor="#000000">
      <tr>
        <td colspan="3" align="center" bgcolor="#0066FF" style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
        <td rowspan="2" align="center" bgcolor="#0066FF" style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
        <td width="1%" style="border:none">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#0066FF" style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#0066FF" style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
      </tr>
      <tr>
        <td colspan="3" align="center" bgcolor="#0066FF" style="border:none;font-size:12"><strong>Fundado el 9 de julio de 1916.  Persona Juridica 2590</strong></td>
        <td width="1%" style="border:none">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#0066FF" style="border:none;font-size:12"><strong>Fundado el 9 de julio de 1916.  Persona Juridica 2590</strong></td>
      </tr>
      <tr>
        <td style="border:none">Fecha:</td>
        <td style="border:none"><strong>
         <?=date("d-m-Y", strtotime($m->fecha_pago))?>
        </strong></td>
        <td style="border:none">Rec.Nº:</td>
        <td style="border:none"><strong>
        <?=$m->nro_recibo?>
        </strong></td>
        <td style="border:none"></td>
        <td style="border:none">Fecha:</td>
        <td style="border:none"><strong>
        <?=date("d-m-Y", strtotime($m->fecha_pago))?>
        </strong></td>
        <td style="border:none">Rec.Nº:</td>
        <td style="border:none"><strong>
        <?=$m->nro_recibo?>
        </strong></td>
      </tr>
      <tr>
        <td style="border:none">Socio/Cliente:</td>
        <td style="border:none" colspan="3"><strong>
         <?php 
            if ($m->fk_cliente!=""){
                echo $m->socio->apellido_nombre;    
            }else{
                echo $m->cliente->razon_social;
            } 
            
        ?>
        </strong></td>
       
        <td style="border:none">&nbsp;</td>
        <td style="border:none">Socio/Cliente:</td>
        <td style="border:none" colspan="3"><strong>
        <?php 
            if ($m->fk_cliente!=""){
                echo $m->socio->apellido_nombre;    
            }else{
                echo $m->cliente->razon_social;
            } 
            
        ?>
        </strong></td>
        
        
      </tr>
      <tr>
       <?php foreach ($modelDetalle as $md) {
            $periodom = $md->periodo_mes . "-" . $md->periodo_anio;
         }?>
        <td style="border:none">Matricula:</td>
        <td style="border:none"><strong>
        <?=$m->socio->matricula?>
        </strong></td>
        <td style="border:none">Periodo:</td>
        <td style="border:none"><strong>        
          <?= $periodom ?>
        </strong></td>
        <td style="border:none">&nbsp;</td>
        <td style="border:none">Matricula:</td>
        <td style="border:none"><strong>
        <?=$m->socio->matricula?>
        </strong></td>
        <td style="border:none">Periodo:</td>
        <td style="border:none"><strong>
         <?= $periodom ?>
        </strong></td>
      </tr>
      <tr>
        <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
        <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
        <td style="border:none">&nbsp;</td>
        <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
        <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
      </tr>

    <?php $total = 0;?>
    <?php foreach ($modelDetalle as $md) {?>
        <!-- movimiento detalle cuentas conceptos-->
        <tr>
        <td colspan="3"><strong>
        <?=$md->subCuenta->concepto?>
        ..........</strong></td>
        <td align="center"><strong>
        $ <?=$md->importe?>
        </strong></td>
        <td style="border:none">&nbsp;</td>
        <td colspan="3"><strong>
        <?=$md->subCuenta->concepto?>
        ..........</strong></td>
        <td align="center"><strong>
        $ <?=$md->importe?>
        </strong></td>
      </tr>

        <?php $total = $md->importe + $total;?>

    <?php }?>

    <!-- codigo html parte de abajo-->
    <tr>
        <td style="border:none"><br><br><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
        <td style="border:none"><br><br></td>
        <td align="right" ><br><br><strong>TOTAL:</strong></td>
        <td align="center"><br><br><br><strong>$
        <?=$total?>
        </strong></td>
        <td style="border:none"></td>
        <td style="border:none"><br><br><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
        <td align="center" style="border:none"><br><br><p><strong>...........................</strong><br><br><p>Firma</p></td>
      <td align="right" ><br><br><strong>TOTAL</strong></td>
        <td align="center"><br><br><br><strong>$
        <?=$total?>
        </strong></td>
      </tr>
    </table>





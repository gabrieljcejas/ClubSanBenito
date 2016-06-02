<?php

//use yii\helpers\Html;
use app\models\Recibo;
//echo yii::$app->urlManager->baseUrl.'/fotos/'.$model->nombre_foto;die

?><head>
<style>
@page{
margin-top: 0.5cm; usable in first page only
margin-right: 0.5cm;
margin-left: 0.5cm;
} 
</style>
</head>
    <?php foreach ($socio as $s){?>

        <?php $total = 0; ?>

        <!-- codigo html tabla-->
        
<table width="100%" border="1" bordercolor="#000000">
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
            <?=$s->socio_id?>
            </strong></td>
            <td>Recibo Nº:</td>
            <td  style="border:none"><strong>
            <?=$s->nro_recibo?>
            </strong></td>
            <td style="border:none"></td>
            <td>Socio Nº:</td>
            <td  style="border:none"><strong>
            <?=$s->socio_id?>
            </strong></td>
            <td>Recibo Nº:</td>
            <td  style="border:none"><strong>
            <?=$s->nro_recibo?>
            </strong></td>
          </tr>
          <tr>
            <td>Apellido y Nombre:</td>
            <td  style="border:none"><strong>
            <?=$s->socio->apellido_nombre?>
            </strong></td>
            <td>Fecha:</td>
            <td  style="border:none"><strong>
            <?=$fecha?>
            </strong></td>
            <td style="border:none"></td>
            <td>Apellido y Nombre:</td>
            <td  style="border:none"><strong>
            <?=$s->socio->apellido_nombre?>
            </strong></td>
            <td>Fecha:</td>
            <td  style="border:none"><strong>
            <?=$fecha?>
            </strong></td>
          </tr>
          <tr>
            <td>Domicilio:</td>
            <td  style="border:none"><strong>
            <?=$s->socio->direccion?>
            </strong></td>
            <td>Periodo:</td>
            <td  style="border:none"><strong>
            <?=$s->periodo_mes . $m->periodo_anio ?>
            </strong></td>
            <td style="border:none">&nbsp;</td>
            <td>Domicilio:</td>
            <td  style="border:none"><strong>
            <?=$s->socio->direccion?>
            </strong></td>
            <td>Periodo:</td>
            <td  style="border:none"><strong>
            <?=$s->periodo_mes . $s->periodo_anio ?>
            </strong></td>
          </tr>
          <tr>
            <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
            <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
            <td style="border:none">&nbsp;</td>
            <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
            <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
          </tr>  

        <?php foreach ($model as $m){?>
            
            <?php if ($s->socio_id == $m->socio_id){?>
            <!-- codigo html itmens cuentas conceptos-->
            <tr>
            <td colspan="3" ><strong>
            <?=$m->subCuenta->concepto?>
            ..........</strong></td>
            <td align="center" ><strong>$ 
            <?=$m->importe_apagar?>
            </strong></td>
            <td style="border:none">&nbsp;</td>
            <td colspan="3" ><?=$m->subCuenta->concepto?>..........</td>
            <td align="center" >$ <?=$m->importe_apagar?></td>
          </tr>      
            
            <?php $total = $m->importe_apagar + $total; ?>

            <?php } ?>

        <?php } ?>
        <!-- codigo html parte de abajo-->
        <tr>
            <td  style="border:none"><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
            <td align="center"  style="border:none"><p>...........................</p><p>Firma</p></td>
            <td><strong>TOTAL</strong></td>
            <td  align="center"><strong>$ 
            <?= $total ?>
            </strong></td>
            <td style="border:none">&nbsp;</td>
            <td  style="border:none"><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
            <td align="center"  style="border:none"><p>...........................</p><p>Firma</p></td>
            <td><strong>TOTAL</strong></td>
            <td align="center"><strong>$ 
            <?= $total ?>
            </strong></td>
          </tr>
        </table>
        
    <?php } ?>
    

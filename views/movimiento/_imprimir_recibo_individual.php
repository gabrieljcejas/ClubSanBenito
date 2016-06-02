<head>
<style>
@page{
  margin-top: 0.5cm; usable in first page only
  margin-right: 0.5cm;
  margin-left: 0.5cm;
} 
</style>
</head>
      <!-- codigo html tabla-->
    <table width="100%" border="1" bordercolor="#000000">
      <tr>
        <td colspan="3" align="center" bgcolor="#0066FF" style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
        <td rowspan="2" align="center" bgcolor="#0066FF" style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
        <td width="1%" style="border:none">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#0066FF" style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#0066FF" style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
      </tr>
      <tr>
        <td colspan="3" align="center" bgcolor="#0066FF" style="border:none"><strong>Fundado el 9 de julio de 1916.  Persona Juridica 2590</strong></td>
        <td width="1%" style="border:none">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#0066FF" style="border:none"><strong>Fundado el 9 de julio de 1916.  Persona Juridica 2590</strong></td>
      </tr>
      <tr>
        <td>Socio Nº:</td>
        <td style="border:none"><strong>
        <?=$m->socio->id?>
        </strong></td>
        <td>Recibo Nº:</td>
        <td style="border:none"><strong>
        <?=$nro_recibo?>
        </strong></td>
        <td style="border:none"></td>
        <td>Socio Nº:</td>
        <td style="border:none"><strong>
        <?=$m->socio->id?>
        </strong></td>
        <td>Recibo Nº:</td>
        <td style="border:none"><strong>
        <?=$nro_recibo?>
        </strong></td>
      </tr>
      <tr>
        <td>Apellido y Nombre:</td>
        <td style="border:none"><strong>
        <?=$m->socio->apellido_nombre?>
        </strong></td>
        <td>Fecha:</td>
        <td style="border:none"><strong>
        <?=date("d-m-Y",strtotime($m->fecha_pago))?>
        </strong></td>
        <td style="border:none">&nbsp;</td>
        <td>Apellido y Nombre:</td>
        <td style="border:none"><strong>
        <?=$m->socio->apellido_nombre?>
        </strong></td>
        <td>Fecha:</td>
        <td style="border:none"><strong>
        <?= date("d-m-Y",strtotime($m->fecha_pago))?>
        </strong></td>
      </tr>
      <tr>
        <td>Domicilio:</td>
        <td style="border:none"><strong>
        <?=$m->socio->direccion?>
        </strong></td>
        <td>Periodo:</td>
        <td style="border:none"><strong>
        <?=$modelDetalle->getMes($modelDetalle->periodo_mes) . " " . $modelDetalle->periodo_anio ?>
        </strong></td>
        <td style="border:none">&nbsp;</td>
        <td>Domicilio:</td>
        <td style="border:none"><strong>
        <?=$m->socio->direccion?>
        </strong></td>
        <td>Periodo:</td>
        <td style="border:none"><strong>
        <?=$modelDetalle->getMes($modelDetalle->periodo_mes) . " " . $modelDetalle->periodo_anio ?>
        </strong></td>
      </tr>
      <tr>
        <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
        <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
        <td style="border:none">&nbsp;</td>
        <td colspan="3" align="center" bgcolor="#0066FF"><strong>CONCEPTO</strong></td>
        <td align="center" bgcolor="#0066FF"><strong>IMPORTE</strong></td>
      </tr>  
    
    <?php $total = 0; ?>    
        <!-- movimiento detalle cuentas conceptos-->
        <tr>
        <td colspan="3"><strong>
        <?=$modelDetalle->subCuenta->concepto?>
        ..........</strong></td>
        <td align="center"><strong>
        $ <?=$modelDetalle->importe?>
        </strong></td>
        <td style="border:none">&nbsp;</td>
        <td colspan="3"><strong>
        <?=$modelDetalle->subCuenta->concepto?>
        ..........</strong></td>
        <td align="center"><strong>
        $ <?=$modelDetalle->importe?>
        </strong></td>
      </tr>      
        
        <?php $total = $modelDetalle->importe; ?>
    
   
    <!-- codigo html parte de abajo-->
    <tr>
        <td style="border:none"><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
        <td align="center" style="border:none"><p><strong>...........................</strong></p>          <p>Firma</p></td>
        <td align="right" ><strong>TOTAL:</strong></td>
        <td align="center"><strong>$ 
        <?= $total ?>
        </strong></td>
        <td style="border:none"></td>
        <td style="border:none"><barcode code="<?=$m->socio->dni?>" type="I25" /></td>
        <td align="center" style="border:none"><p><strong>...........................</strong></p>          <p>Firma</p></td>
      <td align="right" ><strong>TOTAL</strong></td>
        <td align="center"><strong>$ 
        <?= $total ?>
        </strong></td>
      </tr>
    </table>
    




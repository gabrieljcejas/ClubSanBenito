<table border="1">
  <tr>
    <td rowspan="2" align="center" bgcolor="#0066FF" style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
    <td colspan="2" align="center" bgcolor="#0066FF" style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center" colspan="2" bgcolor="#0066FF">ORDEN DE PAGO N°: <strong><?=$m->nro_recibo?></strong></td>
  </tr>
  <tr>
    <td colspan="3" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td>FECHA:</td>
    <td style="border:none"><strong><?=date("d-m-Y", strtotime($m->fecha_pago))?></strong></td>
    <td style="border:none"></td>
  </tr>
  <tr>
    <td>NOMBRE O RAZON SOCIAL:</td>
    <td colspan="2" style="border:none"><strong><?=$m->proveedor->nombre?></strong></td>
  </tr>
  <tr>
    <td>PERIODO:</td>
    <td colspan="2" style="border:none"><strong><?=$m->getPeriodo($m->id)?></strong></td>
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"  bgcolor="#0066FF">CONCEPTO</td>
    <td colspan="2" align="center"  bgcolor="#0066FF">IMPORTE</td>
  </tr>  
  <?php foreach ($modelDetalle as $md) {?>
  <tr>
    <td colspan="2" align="center"><strong><?=$md->subCuenta->concepto?></strong></td>
    <td colspan="2"  align="center"><strong>$ <?=$md->importe?></strong></td>    
  </tr>
  <?php $suma = $md->importe + $suma?>
  <?php } ?>
  <tr>
    <td colspan="2" align="right" style="border:none"><strong>TOTAL:</strong></td>
    <td colspan="2" align="center"><strong>$<?=$suma?></strong></td>
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>   
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="border:none">&nbsp;</td>
    <td align="center" style="border:none">...........................................</td>
  </tr>
  <tr>
    <td colspan="2" style="border:none">ORIGINAL</td>
    <td align="center" style="border:none">FIRMA</td>
  </tr>
</table>
<br>
<table border="1">
  <tr>
    <td rowspan="2" align="center" bgcolor="#0066FF" style="border:none"><img src="<?=yii::$app->urlManager->baseUrl . '/img/logo.jpeg'?>" width="50"></td>
    <td colspan="2" align="center" bgcolor="#0066FF" style="border:none"><strong>CLUB ATLETICO Y SOCIAL SAN BENITO</strong></td>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center" colspan="2" bgcolor="#0066FF">ORDEN DE PAGO N°: <strong><?=$m->nro_recibo?></strong></td>
  </tr>
  <tr>
    <td colspan="3" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td>FECHA:</td>
    <td style="border:none"><strong><?=date("d-m-Y", strtotime($m->fecha_pago))?></strong></td>
    <td style="border:none"></td>
  </tr>
  <tr>
    <td>NOMBRE O RAZON SOCIAL:</td>
    <td colspan="2" style="border:none"><strong><?=$m->proveedor->nombre?></strong></td>
  </tr>
  <tr>
    <td>PERIODO:</td>
    <td colspan="2" style="border:none"><strong><?=$m->getPeriodo($m->id)?></strong></td>
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"  bgcolor="#0066FF">CONCEPTO</td>
    <td colspan="2" align="center"  bgcolor="#0066FF">IMPORTE</td>
  </tr>
 <?php foreach ($modelDetalle as $md) {?>
  <tr>
    <td colspan="2" align="center"><strong><?=$md->subCuenta->concepto?></strong></td>
    <td colspan="2" align="center"><strong>$ <?=$md->importe?></strong></td>      
  </tr>    
  <?php } ?>
  <tr>
    <td colspan="2" align="right" style="border:none"><strong>TOTAL:</strong></td>
    <td colspan="2" align="center"><strong>$<?=$suma?></strong></td>
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>   
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:none" colspan="2" >&nbsp;</td>
    <td colspan="2" style="border:none">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="border:none">&nbsp;</td>
    <td align="center" style="border:none">...........................................</td>
  </tr>
  <tr>
    <td colspan="2" style="border:none">COPIA</td>
    <td align="center" style="border:none">FIRMA</td>
  </tr>
</table>
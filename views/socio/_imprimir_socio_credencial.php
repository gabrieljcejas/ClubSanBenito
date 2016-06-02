<?php

//use yii\helpers\Html;
//echo yii::$app->urlManager->baseUrl.'/fotos/'.$model->nombre_foto;die
?>
<?php foreach ($listSocios as $socio) { ?>    

    <table border="0" width="9cm" height="5.5cm">    

        <tr><td><b>SOCIO Nº: <?= $socio->id ?></b></td><td colspan="2" style="text-align: center"><b>CLUB ATLETICO Y SOCIAL SAN BENITO</b></td></tr>

        <tr><td rowspan="4" width="3cm"><img src="<?= yii::$app->urlManager->baseUrl.'/fotos/'.$socio->nombre_foto ?>" width="150"></td><td>NOMBRE:</td><td><b><?= $socio->apellido_nombre ?></b></td></tr>

        <tr><td>MATRICULA:</td><td><b><?= $socio->matricula ?></b></td></tr>

        <tr><td>FECHA NACIMIENTO:</td><td><b><?= date('d-m-Y', strtotime($socio->fecha_nacimiento)) ?></b></td></tr>

        <tr><td>CATEGORIA:</td><td><b><?= $socio->categoriaSocial->descripcion ?></b></td></tr>

        <tr><td colspan="3" ><barcode code="<?= $socio->dni ?>" type="I25" /></td></tr>    

    </table>
    <br>

<?php } ?>
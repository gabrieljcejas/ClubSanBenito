<?php
use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\web\Session;

/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;
$session->open();
AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body>

<?php $this->beginBody()?>
    <div class="wrap">
        <?php
NavBar::begin([
	'brandLabel' => 'Sistema de Administracion',
	'brandUrl' => Yii::$app->homeUrl,
	'options' => [
		'class' => 'navbar-inverse navbar-fixed-top',
	],
]);
echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => [
		['label' => 'Socios', 'url' => ['#'],
			'items' => [
				['label' => 'Alta-Baja-Modificacion (ABM)', 'url' => ['/socio/index']],
				['label' => 'Estados de Cuentas', 'url' => ['/movimiento/estado-cuenta']],
				['label' => 'Generar Debitos', 'url' => ['/movimiento/generar-debito']],
				//['label' => 'Imprimir Cuotas Anticipadas', 'url' => ['/estado-cuenta/generar-debito']],
				//['label' => 'Asistencias', 'url' => ['/asistencia/index']],
				['label' => 'Emitir Credenciales', 'url' => ['/socio/credencial']],
				//['label' => 'Generar Cuotas Anuales', 'url' => ['/estado-cuenta/generar-cuota-anual']],
				'<li class="divider"></li>',
				['label' => 'ABM Categorias Sociales', 'url' => ['/categoria-social/index']],
				['label' => 'ABM Debitos', 'url' => ['/debito/index']],
				['label' => 'ABM Provincias', 'url' => ['/provincia/index']],
				['label' => 'ABM Ciudades', 'url' => ['/ciudad/index']],
				['label' => 'ABM Cobradores', 'url' => ['/cobrador/index']],

			],

		],
		['label' => 'Tesoreria', 'url' => ['#'],
			'items' => [
				['label' => 'Ingresos', 'url' => ['movimiento/view', 'v' => 'i']],
				['label' => 'Egresos', 'url' => ['movimiento/view', 'v' => 'e']],
				['label' => 'Plan de Cuentas', 'url' => ['/cuenta/index']],
				'<li class="divider"></li>',
				['label' => 'ABM Proveedores', 'url' => ['/proveedor/index']],
				['label' => 'ABM Clientes', 'url' => ['/cliente/index']],
			],
		],
		['label' => 'Reportes', 'url' => ['#'],
			'items' => [
				['label' => 'Detalles Movimiento De Caja', 'url' => ['movimiento/consulta-movimiento-caja']],
				['label' => 'Detalles de Ingresos', 'url' => ['movimiento/consulta-ingresos']],
				['label' => 'Detalles de Egresos', 'url' => ['movimiento/consulta-egresos']],
				['label' => 'Pago a Proveedores', 'url' => ['movimiento/consulta-proveedor']],
				['label' => 'Estado de Cuenta', 'url' => ['movimiento/consulta-estado-cuenta']],
				['label' => 'Listado de Socios', 'url' => ['socio/listado-socio']],
				//'<li class="divider"></li>',
				//['label' => 'Estado de Cuenta', 'url' => ['/proveedor/index']],
			],
		],
		
		
		['label' => 'Admin', 'url' => ['#'],
			'items' => [
				['label' => 'Roles', 'url' => ['rol/index']],
				['label' => 'Operaciones', 'url' => ['operacion/index']],
				['label' => 'Usuarios', 'url' => ['user/index']],
			],
		],	

		Yii::$app->user->isGuest ?
			['label' => 'Login', 'url' => ['/site/login']] :
			['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
			'url' => ['/site/logout'],
			'linkOptions' => ['data-method' => 'post']],

			
	],
]);
NavBar::end();
?>
<br><br><br>
        <div class="container">
            <?=Breadcrumbs::widget([
	'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])?>
            <?=$content?>
        </div>
    </div>

    <!--<footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Copyright <?=date('Y')?></p>
            <p class="pull-right"><?=Yii::powered()?></p>
        </div>
    </footer>-->

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>

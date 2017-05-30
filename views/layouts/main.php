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
				['label' => 'Alta', 'url' => ['/socio/index']],
				['label' => 'Estados de Cuentas', 'url' => ['/movimiento/estado-cuenta']],				
				//['label' => 'Imprimir Cuotas Anticipadas', 'url' => ['/estado-cuenta/generar-debito']],
				//['label' => 'Asistencias', 'url' => ['/asistencia/index']],
				['label' => 'Emitir Credenciales', 'url' => ['/socio/credencial']],
				//['label' => 'Generar Cuotas Anuales', 'url' => ['/estado-cuenta/generar-cuota-anual']],
				
			],

		],
		['label' => 'Tesoreria', 'url' => ['#'],
			'items' => [
				['label' => 'Ingresos', 'url' => ['movimiento/view', 'v' => 'i']],
				['label' => 'Egresos', 'url' => ['movimiento/view', 'v' => 'e']],
				['label' => 'Generar Debitos', 'url' => ['/movimiento/generar-debito']],
				['label' => 'Plan de Cuentas', 'url' => ['/cuenta/index']],
			],
		],
		['label' => 'ABM', 'url' => ['#'],
			'items' => [
				['label' => 'Categorias Sociales', 'url' => ['/categoria-social/index']],
				['label' => 'Debitos', 'url' => ['/debito/index']],
				['label' => 'Provincias', 'url' => ['/provincia/index']],
				['label' => 'Ciudades', 'url' => ['/ciudad/index']],
				['label' => 'Cobradores', 'url' => ['/cobrador/index']],
				['label' => 'Proveedores', 'url' => ['/proveedor/index']],
				['label' => 'Clientes', 'url' => ['/cliente/index']],
			],
		],

		['label' => 'Consultas', 'url' => ['#'],
			'items' => [
				['label' => 'Balances', 'url' => ['movimiento/consulta-balance']],
				['label' => 'Movimientos De Caja', 'url' => ['movimiento/consulta-movimiento-caja']],
				//['label' => 'Movimientos de Caja Agrupado por Cuenta', 'url' => ['movimiento/consulta-movimiento-cuenta']],
				['label' => 'Detalles de Ingresos', 'url' => ['movimiento/consulta-ingresos']],
				['label' => 'Detalles de Egresos', 'url' => ['movimiento/consulta-proveedor']],
				//['label' => 'Recibos Anulados', 'url' => ['movimiento/consulta-recibos-anulados']],
				['label' => 'Estado de Cuenta Socios', 'url' => ['movimiento/consulta-estado-cuenta']],
				['label' => 'Libro de Socios', 'url' => ['movimiento/consulta-libro-socio']],
				['label' => 'Listado de Socios', 'url' => ['socio/listado-socio']],
				//'<li class="divider"></li>',
				//['label' => 'Estado de Cuenta', 'url' => ['/proveedor/index']],
			],
		],		
		
		['label' => 'Admin', 'url' => ['#'],
			'items' => [
				['label' => 'Usuarios', 'url' => ['user/index']],
				['label' => 'Roles', 'url' => ['rol/index']],				
				['label' => 'Permisos', 'url' => ['operacion/index']],							
				['label' => 'Backup', 'url' => ['user/backup']],				
			],
			'visible' => !Yii::$app->user->isGuest		
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

   

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>

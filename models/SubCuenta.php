<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcuenta".
 *
 * @property integer $id
 * @property string $id_cuenta
 * @property string $codigo
 * @property string $concepto
 * @property string $nsubcuenta
 */
class SubCuenta extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */

	public static function tableName() {
		return 'subcuenta';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id_cuenta'], 'string', 'max' => 15],
			[['codigo'], 'string', 'max' => 15],
			[['concepto'], 'string', 'max' => 60],
			[['nsubcuenta'], 'string', 'max' => 40],
		];
	}

	public function attributeLabels() {
		return [
			'id' => '',
			'id_cuenta' => '',
			'codigo' => 'Nuevo Codigo',
			'concepto' => 'Concepto',
			'nsubcuenta' => 'Nsubcuentas',
		];
	}

	public function recursividad($sc) {

		if (empty($sc->nsubcuenta) || $sc->nsubcuenta == null) {

			if ($sc != null){
				echo "
					<li>
						<input type='checkbox' id='item-" . $sc->codigo . "' value=" . $sc->codigo . " />
						<label for='item-" . $sc->codigo . "'" . ">" . $sc->codigo . " " . $sc->concepto . "</label>
					</li>
				";
			}else{
				echo"";
			}

			return;
		} else {

			echo "<li>
					<input type='checkbox' id='item-" . $sc->codigo . "' value=" . $sc->codigo . " />
					<label for='item-" . $sc->codigo . "'" . ">" . $sc->codigo . " " . $sc->concepto . "</label>
					<ul>
			";

			// extraer las subcuentas y devuelve array con los id de subcuenta
			$extraer = explode('-', $sc->nsubcuenta);
			//recorro el array por cada subcuenta
			foreach ($extraer as $valor) {
				// busco subcuenta con el id
				//echo $sc[$valor];die;
				$subCuentas = SubCuenta::find()
					->where(['=', 'id', $valor])
					->one();
				//var_dump($subCuentas);die;
				$this->recursividad($subCuentas);
			}
			echo "</ul>

				</li>";
		}

	}

}

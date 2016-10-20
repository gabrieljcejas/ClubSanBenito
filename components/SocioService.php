<?php

namespace app\components;

use Yii;
use app\models\Socio;
use app\models\SocioDebito;
use yii\data\ActiveDataProvider;

class SocioService extends \yii\db\ActiveRecord {

    public function saludar() {
        echo"Hola";
    }

    public function getProximoId() {
        $model = new Socio();

        $dataProvider = $model->findLastId();

        foreach ($dataProvider as $p) {
            $proximoIDSocio = $p->id + 1;
            break;
        }

        return $proximoIDSocio;
    }

    public function findSocioDebitoById($id) {

        $query = SocioDebito::find()->where(['id_socio' => $id]);

        $dataProvider = new ActiveDataProvider([
          'query' => $query,
        ]);
        //var_dump($dataProvider);die;
        return $dataProvider;
    }

    public function findSocioDebitoByIdJson($id) {

        $query = SocioDebito::find()->where(['id_socio' => $id])->all();

        $debitos = array();  

        foreach ($query as $sd) {
               
            $debitos[] = array('id' => $sd->debito->id, 'concepto' => $sd->debito->concepto);  

        }
                
        return $debitos;
    }

     public function calcularEdad($fecha) {
        list($Y, $m, $d) = explode("-", $fecha);
        return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
    }

    public function calcularAntiguedad($fecha) {

        if ($fecha!=""){
            list($Y, $m, $d) = explode("-", $fecha);
            $dia = date(j);
            $mes = date(n);
            $ano = date(Y);

            // diferencia dias
            if ($dia > $d) {
                $total_dias = $dia - $d;
            } else {
                $total_dias = $d - $dia;
            }
            // diferencia meses
            if ($mes > $m) {
                $total_meses = $mes - $m;
            } else {
                $total_meses = $m - $mes;
            }

            $total_anios = $ano - $Y;

            return $total_anios ." años ".$total_meses." meses ".$total_dias." dias";
        }else{
            return "";
        }
    }
    
    
    public function findSocioByCodigo($desde,$hasta) {
        
        $query= Socio::find()
                ->where('id>=:desde AND id<=:hasta',['desde'=>$desde,'hasta'=>$hasta])
                ->all();       
        
        return $query;
    }

}

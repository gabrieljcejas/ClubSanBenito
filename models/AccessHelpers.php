<?php
namespace app\models;

use Yii;


class AccessHelpers {

    public static function getAcceso($operacion)
    {
        $connection = \Yii::$app->db;
        $sql = "SELECT o.nombre
                FROM user u
                JOIN rol r ON u.rol_id = r.id
                JOIN rol_operacion ro ON r.id = ro.rol_id
                JOIN operacion o ON ro.operacion_id = o.id
                WHERE o.nombre =:operacion
                AND u.rol_id =:rol_id";
        $command = $connection->createCommand($sql);
        $command->bindValue(":operacion", $operacion);
        $command->bindValue(":rol_id", Yii::$app->user->identity->rol_id);
        $result = $command->queryOne();

        if ($result['nombre'] != null){

            return true;
            
        }elseif (Yii::$app->user->identity->rol_id === 1) {// si el rol es 1 (administrador) devuelvo true para no tener que agregar todos los permisos en la tabla operaciones
            return true;

        }else{

            return false;
        }
    }

}

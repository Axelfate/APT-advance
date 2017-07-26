<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ubicacion".
 *
 * @property integer $idUbicacion
 * @property string $hotel
 * @property string $pais
 * @property string $estado
 * @property string $direccion
 *
 * @property Departamento[] $departamentos
 * @property Usuario[] $usuarios
 */
class Ubicacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ubicacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel', 'pais', 'estado', 'direccion'], 'required'],
            [['hotel', 'pais', 'estado'], 'string', 'max' => 50],
            [['direccion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUbicacion' => 'Id Ubicacion',
            'hotel' => 'Hotel',
            'pais' => 'Pais',
            'estado' => 'Estado',
            'direccion' => 'Direccion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasMany(Departamento::className(), ['localizacion' => 'idUbicacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['establecimiento' => 'idUbicacion']);
    }
}

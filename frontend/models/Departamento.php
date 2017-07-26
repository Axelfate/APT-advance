<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "departamento".
 *
 * @property integer $idDepartamento
 * @property string $nombre
 * @property integer $localizacion
 * @property integer $encargado
 *
 * @property Ubicacion $localizacion0
 * @property Usuario $idDepartamento0
 * @property Tarea[] $tareas
 * @property Usuario[] $usuarios
 */
class Departamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'departamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'encargado'], 'required'],
            [['localizacion', 'encargado'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['localizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['localizacion' => 'idUbicacion']],
            [['idDepartamento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idDepartamento' => 'idUsuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDepartamento' => 'Id Departamento',
            'nombre' => 'Nombre',
            'localizacion' => 'Localizacion',
            'encargado' => 'Encargado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacion0()
    {
        return $this->hasOne(Ubicacion::className(), ['idUbicacion' => 'localizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDepartamento0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idDepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareas()
    {
        return $this->hasMany(Tarea::className(), ['departamento_asignado' => 'idDepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['pertenece_departamento' => 'idDepartamento']);
    }
}

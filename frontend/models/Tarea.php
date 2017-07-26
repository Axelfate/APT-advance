<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tarea".
 *
 * @property integer $idTarea
 * @property string $descripcion_corta
 * @property string $descripcion_larga
 * @property integer $ubicacion 
 * @property integer $asignado_a
 * @property integer $creado_por
 * @property integer $departamento_asignado
 * @property string $fecha_inicio
 * @property string $fecha_propuesta_fin
 * @property integer $estado
 * @property string $notas
 *
 * @property Usuario $asignadoA
 * @property Usuario $creadoPor
 * @property Departamento $departamentoAsignado
 * @property Status $estado0
 * @property Ubicacion $ubicacion0 
 */
class Tarea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_corta', 'descripcion_larga', 'fecha_inicio', 'fecha_propuesta_fin'], 'required'],
            [['ubicacion', 'asignado_a', 'creado_por', 'departamento_asignado', 'estado'], 'integer'],
            [['fecha_inicio', 'fecha_propuesta_fin'], 'safe'],
            [['descripcion_corta'], 'string', 'max' => 50],
            [['descripcion_larga'], 'string', 'max' => 300],
            [['notas'], 'string', 'max' => 200],
            [['asignado_a'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['asignado_a' => 'idUsuario']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['creado_por' => 'idUsuario']],
            [['departamento_asignado'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_asignado' => 'idDepartamento']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['estado' => 'idStatus']],
            [['ubicacion'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['ubicacion' => 'idUbicacion']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTarea' => 'Id Tarea',
            'descripcion_corta' => 'Descripcion Corta',
            'descripcion_larga' => 'Descripcion Larga',
            'ubicacion' => 'Ubicacion', 
            'asignado_a' => 'Asignado A',
            'creado_por' => 'Creado Por',
            'departamento_asignado' => 'Departamento Asignado',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_propuesta_fin' => 'Fecha Propuesta Fin',
            'estado' => 'Estado',
            'notas' => 'Notas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignadoA()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'asignado_a']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentoAsignado()
    {
        return $this->hasOne(Departamento::className(), ['idDepartamento' => 'departamento_asignado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Status::className(), ['idStatus' => 'estado']);
    }

     /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getUbicacion0() 
    { 
       return $this->hasOne(Ubicacion::className(), ['idUbicacion' => 'ubicacion']); 
    } 
}

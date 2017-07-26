<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $idUsuario
 * @property string $nombres
 * @property string $apellidos
 * @property integer $establecimiento
 * @property integer $pertenece_departamento
 * @property string $password
 * @property integer $cargo
 * @property string $username
 * @property string $hotel
 *
 * @property Tarea[] $tareas
 * @property Tarea[] $tareas0
 * @property Ubicacion $establecimiento0
 * @property Departamento $perteneceDepartamento
 * @property Tipousuario $cargo0
 * @property Ubicacion $hotel
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombres', 'apellidos', 'password', 'username'], 'required'],
            [['establecimiento', 'pertenece_departamento', 'cargo'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 50],
            [['establecimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::className(), 'targetAttribute' => ['establecimiento' => 'idUbicacion']],
            [['pertenece_departamento'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['pertenece_departamento' => 'idDepartamento']],
            [['cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipousuario::className(), 'targetAttribute' => ['cargo' => 'idTipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'establecimiento' => 'Establecimiento',
            'pertenece_departamento' => 'Pertenece Departamento',
            'password' => 'Password',
            'cargo' => 'Cargo',
            'username' => 'Username',
            'hotel' =>'localizacion'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareas()
    {
        return $this->hasMany(Tarea::className(), ['asignado_a' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareas0()
    {
        return $this->hasMany(Tarea::className(), ['creado_por' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstablecimiento0()
    {
        return $this->hasOne(Ubicacion::className(), ['idUbicacion' => 'establecimiento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerteneceDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['idDepartamento' => 'pertenece_departamento']);
    }

    public function getPerteneceDepartamento2($dep)
    {
        return $this->hasMany(Departamento::className(), ['idDepartamento' => $dep]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo0()
    {
        return $this->hasOne(Tipousuario::className(), ['idTipo' => 'cargo']);
    }

    /*public static function findByDep($dep)
    {
        return static::findAll(['localizacion' => $dep]);
    }*/
}

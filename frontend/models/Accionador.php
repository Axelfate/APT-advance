<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "accionador".
 *
 * @property integer $idAction
 * @property integer $up
 */
class Accionador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accionador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['up'], 'required'],
            [['up'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idAction' => 'Id Action',
            'up' => 'Up',
        ];
    }
}

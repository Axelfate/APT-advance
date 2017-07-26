<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tarea;

/**
 * TareaSearch represents the model behind the search form about `frontend\models\Tarea`.
 */
class TareaSearch2 extends Tarea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTarea', 'asignado_a', 'creado_por', 'departamento_asignado', 'estado', 'ubicacion'], 'integer'],
            [['descripcion_corta', 'descripcion_larga', 'fecha_inicio', 'fecha_propuesta_fin', 'notas'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tarea::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idTarea' => $this->idTarea,
            'asignado_a' => $this->asignado_a,
            'creado_por' => $this->creado_por,
            'departamento_asignado' => $this->departamento_asignado,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_propuesta_fin' => $this->fecha_propuesta_fin,
            'estado' => $this->estado,
            'ubicacion'=>$this->ubicacion,
        ]);

        if(yii::$app->user->identity->cargo===2){
            $this->departamento_asignado=yii::$app->user->identity->pertenece_departamento;
            $this->ubicacion=yii::$app->user->identity->establecimiento;
             /*$query->andFilterWhere(['like', 'departamento_asignado', $this->departamento_asignado])
            ->andFilterWhere(['like', 'asignado_a',$this->asignado_a])
            ->andFilterWhere(['like','ubicacion',$this->ubicacion])
            ->andFilterWhere(['=','estado',1])
            ->orFilterWhere(['=','estado',$this->estado])
            ->orderBy(['estado'=>SORT_DESC]);*/
        }
        elseif(yii::$app->user->identity->cargo===3){
            $this->asignado_a=yii::$app->user->identity->idUsuario;
             /*$query->andFilterWhere(['like', 'departamento_asignado', $this->departamento_asignado])
            ->andFilterWhere(['like', 'asignado_a',$this->asignado_a])
            ->orFilterWhere(['=','estado',$this->estado])
            ->orderBy(['estado'=>SORT_DESC]);*/
        }
        /*if (yii::$app->user->identity->cargo===1) {
        }*/

        //$model->isNewRecord ? 'Create' : 'Update'
        $query->andFilterWhere(['like', 'departamento_asignado', $this->departamento_asignado])
         ->andFilterWhere(['like', 'asignado_a',$this->asignado_a])
         ->andFilterWhere(['=','estado',$this->estado])
         ->orderBy(['estado'=>SORT_DESC]);


        return $dataProvider;
    }
}

<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Tarea;
use frontend\models\TareaSearch;
use frontend\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use frontend\models\Departamento;

/**
 * TareaController implements the CRUD actions for Tarea model.
 */
class TareaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              //'only' => ['view','create','update','delete','bulk-delete'],
              'rules' => [
                  [
                      'actions' => ['login','view','create','update','delete','bulk-delete','getdata', 'editnota', 'editest','getdata2'],
                      'allow' => true,
                      //'roles' => ['?'],
                  ],
                  [
                      'actions' => ['index','view','create','update','delete','bulk-delete','getdata', 'editnota', 'editest','getdata2'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                    'getdata'=>['post'],                    
                    'editnota' => ['post'],
                    'editest' => ['post'],                    
                    'getdata2'=>['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
       return ArrayHelper::merge(parent::actions(), [
           'editnota' => [                                       // identifier for your editable action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => Tarea::className(),                // the update model class
           ],

           'editest' => [                                       // identifier for your editable action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => Tarea::className(),                // the update model class
           ]

       ]);
    }


    /**
     * Lists all Tarea models.
     * @return mixed
     */
    public function actionIndex()
    {
      if (!empty(yii::$app->user->identity))
      {
        $searchModel = new TareaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->user->identity->cargo===1)
        {
          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,]);
        }
        elseif (yii::$app->user->identity->cargo===2)
        {
          return $this->render('index2', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,]);
        }
        else
        {
          return $this->render('index3', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,]);
        }
      } else
      {
        actionLogin();
      }
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('../site/login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Displays a single Tarea model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Tarea #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Tarea model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Tarea();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Tarea",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Tarea",
                    'content'=>'<span class="text-success">Create Tarea success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new Tarea",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->idTarea]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Tarea model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Tarea #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Tarea #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Tarea #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->idTarea]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Tarea model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Tarea model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Tarea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tarea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tarea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*public function actionSubcat() {
    //Yii::$app->response->format = Response::FORMAT_JSON;
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
    $parents = $_POST['depdrop_parents'];
    if ($parents != null) {
    $cat_id = $parents[0];
    $out = self::getSubCatList($cat_id);
    // the getSubCatList function will query the database based on the
    // cat_id and return an array like below:
    // [
    // ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
    // ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
    // ]
    echo Json::encode(['output'=>$out, 'selected'=>'']);
    return;
    }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
    }


    public function actionGetsubgroup($id)
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;

        $rows = Usuario::find()->where(['pertenece_departamento' => $id])
        ->all();
        echo "<option value=''>---Select State---</option>";
        if(count($rows)>0){
            foreach($rows as $row){
                echo "<option value='$row->idUsuario'>$row->nombres</option>";
            }
        }
        else{
            echo "Lista vacia xD";
        }
    }*/


    public function actionGetdata()
    {
    if ($id = Yii::$app->request->post('id')) {
        $operationPosts = Usuario::find()
            ->where(['pertenece_departamento' => $id])
            ->count();

        if ($operationPosts > 0) {
            $operations = Usuario::find()
                ->where(['pertenece_departamento' => $id])
                ->all();
                echo "<option>-Selecciona una opcion-</option>";
            foreach ($operations as $operation)
                echo "<option value='" . $operation->idUsuario . "'>" . $operation->nombres . "</option>";
        } else
            echo "<option>-Selecciona una opcion-</option>";            
    }

  }

    public function actionGetdata2()
    {
    if ($id = Yii::$app->request->post('id')) {
        $operationPosts = Departamento::find()
            ->where(['localizacion' => $id])
            ->count();

        if ($operationPosts > 0) {
            $operations = Departamento::find()
                ->where(['localizacion' => $id])
                ->all();
                echo "<option>-Selecciona una opcion-</option>";
            foreach ($operations as $operation)
                echo "<option value='" . $operation->idDepartamento . "'>" . $operation->nombre . "</option>";
        } else
            echo "<option>-Selecciona una opcion-</option>";            
    }

  }


}

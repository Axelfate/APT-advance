<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use frontend\models\PasswordResetRequestForm;
use common\models\LoginForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\nUbicacionModel;
use frontend\controllers\NUbicacionController;
use frontend\models\SearchnUbicacion;
use frontend\models\TareaSearch;
use frontend\models\Tarea;
use frontend\controllers\TareaController;
use frontend\models\Usuario;
use frontend\models\Departamento;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login','ResetPassword'],
                        'allow' => true,
                        //'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','view','create','update','delete','bulk-delete','getdata','getdata2','editnota', 'editest',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                    'getdata'=>['post'],
                    'getdata2'=>['post'],
                    'editnota' => ['post'],
                    'editest' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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


        /*return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];*/
    }

    /**
     * Displays homepage.
     *
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
          return $this->render('../tarea/index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,]);
        }
        elseif (yii::$app->user->identity->cargo===2)
        {
          return $this->render('../tarea/index2', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,]);
        }
        else
        {
          return $this->render('../tarea/index3', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,]);
        }
      } else
      {
        actionLogin();
      }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
    * Esta es una copia xd
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
                   'content'=>$this->renderAjax('../tarea/view', [
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
                   'title'=> "Nuevo proyecto",
                   'content'=>$this->renderAjax('../tarea/create', [
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
                   'content'=>$this->renderAjax('../tarea/create', [
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
               return $this->redirect(['../tarea/view', 'id' => $model->idTarea]);
           } else {
               return $this->render('../tarea/create', [
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
                   'content'=>$this->renderAjax('../tarea/update', [
                       'model' => $model,
                   ]),
                   'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                               Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
               ];
           }else if($model->load($request->post()) && $model->save()){
               return [
                   'forceReload'=>'#crud-datatable-pjax',
                   'title'=> "Tarea #".$id,
                   'content'=>$this->renderAjax('../tarea/view', [
                       'model' => $model,
                   ]),
                   'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                           Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
               ];
           }else{
                return [
                   'title'=> "Update Tarea #".$id,
                   'content'=>$this->renderAjax('../tarea/update', [
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
               return $this->redirect(['../tarea/view', 'id' => $model->idTarea]);
           } else {
               return $this->render('../tarea/update', [
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
           return $this->redirect(['../tarea/index']);
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
           return $this->redirect(['../tarea/index']);
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

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

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

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
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

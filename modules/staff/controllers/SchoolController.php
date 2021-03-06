<?php

namespace app\modules\staff\controllers;

use Yii;
use app\models\School;
use app\models\searches\SchoolSearch;
use app\models\TypeToSchool;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * SchoolController implements the CRUD actions for School model.
 */
class SchoolController extends Controller
{
    public $layout = 'schools';
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all School models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single School model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return Yii::$app->request->isAjax ?
        $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ])
        :
        $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new School model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new School();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach($model->types as $type_id) {
                $type_school_model = new TypeToSchool();
                $type_school_model->type_id = (int) $type_id;
                $type_school_model->school_id = $model->id;
                $type_school_model->save();
            }
            
            Yii::$app->session->setFlash('success', 'Училище <b>' . Html::encode($model->name) . '</b> беше добавено успешно!');
            $model->refresh();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Успешно добавяне на училище',
            ];
        } 
        
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing School model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            TypeToSchool::deleteAll('school_id = :school', [':school' => $model->id]);
            foreach($model->types as $type_id) {
                $type_school_model = new TypeToSchool();
                $type_school_model->type_id = (int) $type_id;
                $type_school_model->school_id = $model->id;
                $type_school_model->save();
            }
            
            Yii::$app->session->setFlash('success', 'Училище <b>' . Html::encode($model->name) . '</b> беше променено успешно!');
            $model->refresh();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Училището беше променено успешно',
            ];
        } 
        
        $model->types = yii\helpers\ArrayHelper::getColumn($model->schoolTypes, 'id');
        
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    //ajax validation for update and create actions
    public function actionPerformAjax()
    {
        $model = new School();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing School model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $searchModel = new School();
        if($this->findModel($id)->delete())
            Yii::$app->session->setFlash('success', 'Училището беше изтрито успешно!');
    }

    /**
     * Finds the School model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return School the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = School::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

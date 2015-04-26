<?php

namespace app\modules\staff\controllers;

use Yii;
use app\models\SchoolType;
use app\models\searches\SchoolTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * SchoolTypeController implements the CRUD actions for SchoolType model.
 */
class SchoolTypeController extends Controller
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
     * Lists all SchoolType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchoolTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SchoolType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SchoolType(['scenario' => 'create']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<b>' .  Html::encode($model->type) . '</b> беше добавено успешно!');
            $model->refresh();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Успешно добавяне вид',
            ];
        } 
        
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SchoolType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<b>' .  Html::encode($model->type) . '</b> беше променено успешно!');
            $model->refresh();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Успешна промяна на вид',
            ];
        } 
        
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    //ajax validation for update and create actions
    public function actionPerformAjax()
    {
        $model = new SchoolType();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing SchoolType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $searchModel = new SchoolType();
        if($this->findModel($id)->delete())
            Yii::$app->session->setFlash('success', 'Успешно изтрит елемент!');
    }

    /**
     * Finds the SchoolType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SchoolType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SchoolType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

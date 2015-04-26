<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\SchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Училища';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Html::button(
        '<span class="glyphicon glyphicon-plus"></span> Добавяне училище',
        ['value' => Url::to(['school/create']),
            'id' => 'modalButton',
            'class' => 'btn btn-success',
            'title' => 'Добавяне на училище',
        ]) ?>
    <br /><br />
    
    <?php Pjax::begin(['id' => 'schools-container', 'options' => ['class' => 'pjax-wrapper']]) ?>

     <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>' . $message . '</div>';
        }
    ?>
    
    <?= GridView::widget([
        'id' => 'schools-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions'=>['style'=>'width: 60px;']
            ],
            [
                'attribute' => 'name',
                'value' => function ($model) {
                    return htmlspecialchars($model->name, ENT_NOQUOTES);
                },
            ],
            [
                'attribute' => 'types',
                'value' => function ($model) {
                    return implode(', ', yii\helpers\ArrayHelper::getColumn($model->schoolTypes, 'type'));
                },
                'filter' => yii\helpers\ArrayHelper::map(app\models\SchoolType::find()->asArray()->all(),'id','type'),
                'contentOptions'=>['style'=>'width: 160px;'] 
            ],
            [
                'attribute' => 'location_id',
                'value' => function ($model) {
                    return Html::encode($model->location->name);
                },
                'filter' => yii\helpers\ArrayHelper::map(app\models\Location::find()->asArray()->all(),'id','name')
            ],
            [
                'attribute' => 'address',
                'value' => function ($model) {
                    return htmlspecialchars($model->address, ENT_NOQUOTES);
                },
            ],
            [
                'attribute' => 'financing',
                'value' => function ($model) {
                    return $model->financingtype;
                },
                'filter' => app\models\School::$financing_type,
            ],
            [   'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {update} {delete}',
                'headerOptions' => ['width' => '10%', 'class' => 'activity-view-link',],        
                    'contentOptions' => ['class' => 'padding-left-5px'],

                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', $url, [
                            'class' => 'pjax-grid-action',
                            'title' => Html::encode($model->name),
                            'data-toggle' => 'modal',
                            'data-target' => '#site-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'class' => 'pjax-grid-action',
                            'title' => 'Промяна на ' . Html::encode($model->name),
                            'data-toggle' => 'modal',
                            'data-target' => '#site-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'class' => 'grid-delete-action',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
    
    <?php Pjax::end() ?>
</div>
<?php
$js = <<<JS
$("#schools-container").on("pjax:end", function() {
    $.pjax.reload({container:'#nav-schools-container'});
});
JS;
$this->registerJs($js);
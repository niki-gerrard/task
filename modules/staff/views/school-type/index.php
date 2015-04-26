<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\SchoolTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Видове училища';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-type-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Html::button(
        '<span class="glyphicon glyphicon-plus"></span> Добавяне на вид училище',
        ['value' => Url::to(['school-type/create']),
            'id' => 'modalButton',
            'class' => 'btn btn-success',
            'title' => 'Добавяне на вид училище',
        ]) ?>
    <br /><br />

    <?php Pjax::begin(['id' => 'school-types-container', 'options' => ['class' => 'pjax-wrapper']]) ?>

     <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>' . $message . '</div>';
        }
    ?>

    <?= GridView::widget([
        'id' => 'school-types-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions'=>['style'=>'width: 60px;'] // <-- right here
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return Html::encode($model->type);
                },
            ],

            [   'class' => 'yii\grid\ActionColumn', 
                'template' => '{update} {delete}',
                'headerOptions' => ['width' => '10%', 'class' => 'activity-view-link',],        
                    'contentOptions' => ['class' => 'padding-left-5px'],

                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'class' => 'pjax-grid-action',
                            'title' => 'Промяна на ' . Html::encode($model->type),
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
$("#school-types-container").on("pjax:end", function() {
    $.pjax.reload({container:'#nav-schools-container'});
});
JS;
$this->registerJs($js);
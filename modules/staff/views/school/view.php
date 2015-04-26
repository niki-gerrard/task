<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\School */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            
            [
                'attribute' => 'name',
                'value' => htmlspecialchars($model->name, ENT_NOQUOTES),
            ],
            [
                'attribute' => 'fullname',
                'value' => htmlspecialchars($model->fullname, ENT_NOQUOTES),
            ],
            [
                'attribute' => 'types',
                'value' => implode(', ', yii\helpers\ArrayHelper::getColumn($model->schoolTypes, 'type')),
            ],
            [
                'attribute' => 'location_id',
                'value' => Html::encode($model->location->name),
            ],
            [
                'attribute' => 'address',
                'value' => htmlspecialchars($model->address, ENT_NOQUOTES),
            ],
            [
                'attribute' => 'financing',
                'value' => $model->financingtype,
            ],
            [
                'attribute' => 'phone',
                'value' => Html::encode($model->phone),
            ],
            [
                'attribute' => 'phone_director',
                'value' => Html::encode($model->phone_director),
            ],
            [
                'attribute' => 'fax',
                'value' => Html::encode($model->fax),
            ],
            'email:email',
            'website:url',
            [
                'attribute' => 'change',
                'value' => $model->changetype,
            ],
        ],
    ]) ?>

</div>

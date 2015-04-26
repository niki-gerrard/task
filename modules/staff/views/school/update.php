<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\School */

$this->title = 'Update School: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="school-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

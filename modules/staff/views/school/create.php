<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\School */

$this->title = 'Добавяне на училище';
$this->params['breadcrumbs'][] = ['label' => 'Училища', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

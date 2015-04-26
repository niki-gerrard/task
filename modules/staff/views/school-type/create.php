<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolType */

$this->title = 'Create School Type';
$this->params['breadcrumbs'][] = ['label' => 'School Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

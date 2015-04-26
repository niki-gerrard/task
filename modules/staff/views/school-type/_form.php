<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="school-type-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validationUrl' => ['school-type/perform-ajax'],
    ]); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => 256]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавяне' : 'Промяна', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
// get the form id and set the event
$('form#w0').on('beforeSubmit', function(e) {
    var \$form = $(this);
    submitForm(\$form);
    $.pjax.reload({container:'#school-types-container'});
    $('#site-modal').on('hidden.bs.modal', function (e) {
        $(this).find('#site-modal-content').html(" ");
        $(this).find('.modal-header').html(" ");
    });
}).on('submit', function(e){
    e.preventDefault();
});
JS;
$this->registerJs($js);
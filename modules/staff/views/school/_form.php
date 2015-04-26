<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Location;
use app\models\School;
use app\models\SchoolType;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\School */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="school-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validationUrl' => ['school/perform-ajax'],
    ]); ?>

    <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'fullname')->textInput(['maxlength' => 255]) ?>

             <?= $form->field($model, 'location_id')->dropDownList(
                ArrayHelper::map(Location::find()->all(), 'id', 'name'), 
                ['prompt'=>'Изберете населено място']
            );
            ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'financing')->dropDownList(
                School::$financing_type, 
                ['prompt'=>'Финансиране']
            );
            ?>
            
            <?= $form->field($model, 'types')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(SchoolType::find()->all(), 'id', 'type'),
                'options' => [
                    'placeholder' => 'Изберете тип училище ...',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>

            <?= $form->field($model, 'phone_director')->textInput(['maxlength' => 15]) ?>

            <?= $form->field($model, 'fax')->textInput(['maxlength' => 15]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'website')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'change')->dropDownList(
                School::$change_type, 
                ['prompt'=>'Смени']
            );
            ?>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-md-12">
             <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Добавяне' : 'Промяна', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
// get the form id and set the event
$('form#w0').on('beforeSubmit', function(e) {
    var \$form = $(this);
    submitForm(\$form);
    $.pjax.reload({container:'#schools-container'});
    $('#site-modal').on('hidden.bs.modal', function (e) {
        $(this).find('#site-modal-content').html(" ");
        $(this).find('.modal-header').html(" ");
    });
}).on('submit', function(e){
    e.preventDefault();
});
JS;
$this->registerJs($js);
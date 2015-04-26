<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php
use yii\widgets\Pjax;
use yii\bootstrap\Nav;

$schools_count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM school')->queryScalar();
$school_types_count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM school_type')->queryScalar();
?>

<?php Pjax::begin(['id' => 'nav-schools-container', 'options' => ['class' => 'pjax-wrapper']]) ?>
    
    <?php echo Nav::widget([
        'items' => [
            [
                'label' => 'Училища <span class="badge">' . $schools_count . '</span>',
                'url' => ['/staff/school/index'],
                'linkOptions' => [
                    'data-pjax'=>0,
                ],
            ],
            [
                'label' => 'Видове <span class="badge">' . $school_types_count . '</span>',
                'url' => ['/staff/school-type/index'],
                'linkOptions' => [
                    'data-pjax'=>0,
                ],
            ],
        ],
        'encodeLabels' => false,
        'options' => ['class' =>'nav nav-tabs nav-justified'],
    ]); ?>
<?php Pjax::end() ?>

<?= $content ?>

<?php $this->endContent(); ?>
    

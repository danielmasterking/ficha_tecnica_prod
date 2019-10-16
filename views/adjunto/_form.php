<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;

$empleados = array();

foreach ($cedulas as $key => $value) {
	
	$empleados[$value['cedula']] = $value['cedula'];
}
/* @var $this yii\web\View */
/* @var $model app\models\Adjunto */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="adjunto-form">

    <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

        <?php echo $form->field($model, 'cedula')->widget(Select2::classname(),[
         'data'=>$empleados,
         

    ]); ?>

    <?php
     // Usage with ActiveForm and model
     echo $form->field($model, 'image2')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png','pdf']]
     ]);

     ?>

    <div class="form-group">
        <?= Html::submitButton('Subir' , ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

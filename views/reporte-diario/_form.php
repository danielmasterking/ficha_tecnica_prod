<?php
use kartik\widgets\DepDrop ;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use Zelenin\yii\widgets\Summernote\Summernote;
use yii\web\JsExpression;
use app\models\Cliente;
use kartik\widgets\TimePicker;
use yii\helpers\Url;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteDiario */
/* @var $form yii\widgets\ActiveForm */

$data_novedad = array();

foreach ($novedades as $key => $value) {
    
    $data_novedad[$value['id']] = $value['nombre'];
}

// The controller action that will render the list
$url = \yii\helpers\Url::to(['sucursales-list']);

?>

<div class="reporte-diario-form">

   <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

    <div class="form-group">
        <?php

          $data_cliente = array();

          foreach ($clientes as $key => $value) {
              
              $data_cliente[$value['NIT']] = $value['NOMBRE']; 
          }

          

          echo '<label class="control-label">Cliente</label>';
          echo Select2::widget([
              'name' => 'cliente',
              'data' => $data_cliente,
              'options' => [
                  'id' => 'cliente',
                  'placeholder' => 'Seleccione Cliente'
                  
              ],


             ]);


         ?>
    
    
</div>


   <?= Html::activeHiddenInput($model, 'reporte_id',['value' => $reporte_id])?>
   <?= Html::activeHiddenInput($model, 'estado_id',['value' => $estado_id[0]['id']])?>
    
    <?php

                // Child # 1
          echo $form->field($model, 'sucursal_id')->widget(DepDrop::classname(), [
              'type'=>DepDrop::TYPE_SELECT2,
               'data' => [1 => ''],   
              'pluginOptions'=>[
              
                  'depends'=>['cliente'],
                  'placeholder' => 'Select...',
                  'url'=>Url::to(['cliente/listado']),
                  //'params'=>['input-type-1', 'input-type-2']
              ]
          ]);


    ?>


  

    <?= Html::activeHiddenInput($model, 'fecha_registro',['value' => $fecha_registro])?>


    
    
    <?=

       $form->field($model, 'novedad_id')->widget(Select2::classname(), [
       'data' => $data_novedad,
    
      ])


    ?>


    <?=$form->field($model, 'hora')->widget(TimePicker::classname(), [])?>

    
    <?= $form->field($model, 'observacion')->widget(Summernote::className(), [
      
    ]) ?>

     <?php
     // Usage with ActiveForm and model
     echo $form->field($model, 'image2')->widget(FileInput::classname(), [
    //'options' => ['accept' => 'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png', 'pdf']]
     ]);

     ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

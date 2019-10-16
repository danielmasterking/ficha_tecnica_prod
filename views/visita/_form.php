<?php

use kartik\widgets\DepDrop ;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use Zelenin\yii\widgets\Summernote\Summernote;
use kartik\widgets\Select2;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Visita */
/* @var $form yii\widgets\ActiveForm */
$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}

$data = array();
foreach ($clientes as $key => $value) {
  
  $data[$value['nit']] = $value['nombre'];
}

$data_novedad = array();

foreach ($novedades as $key => $value) {
    
    $data_novedad[$value['id']] = $value['nombre'];
}

$data_empleados = array();

foreach ($empleados as $key => $value) {
    
    $data_empleados[$value['NOMBRE']] = $value['NOMBRE'];
}

/*$data_estado = array();

foreach ($estados as $key => $value) {
    
    $data_estado[$value['id']] = $value['nombre'];
}*/

$data_usuarios = array();

foreach ($usuarios as $key ) {
    
    if($key->usuario != 'admin'){

       $data_usuarios[$key->usuario] = $key->nombres.' '.$key->apellidos;    
    }
    
}


?>

<div class="visita-form">

    <?php $form = ActiveForm::begin(); ?>

     <?php
     
     if(isset($actualizar)){
         
         echo $form->field($model, 'fecha')->widget(DateControl::classname(), [
	      'displayFormat' => 'php:Y-m-d',
	      'type'=>DateControl::FORMAT_DATE,
	      'options' => ['disabled' => 'disabled']
	       ]);

      }else{

       echo $form->field($model, 'fecha')->widget(DateControl::classname(), [
      'autoWidget'=>true,
     'displayFormat' => 'php:Y-m-d',
     'saveFormat' => 'php:Y-m-d',
      'type'=>DateControl::FORMAT_DATE,
     
       ]);

      }
    ?>

    <?php

           if(isset($actualizar)){

    ?>

            <input type="text" class=" form-control" value="<?= $model->sucursal->cliente->nombre?>" disabled/>
    <?php
             


           }else{

             echo Select2::widget([
            'name' => 'cliente',
            'data' => $data,
            'options' => [
                'id' => 'cliente',
                'placeholder' => 'Seleccione Cliente'
                
             ],


             ]);

           }


            if(isset($actualizar)){


              ?>

               <input type="text" class=" form-control" value="<?= $model->sucursal->nombre?>" disabled/>

              <?php


            }else{

                             // Child # 1
            echo $form->field($model, 'sucursal_id')->widget(DepDrop::classname(), [
                'options' => ['id' => 'sucursal'],
                'type'=>DepDrop::TYPE_SELECT2,
                 'data' => [1 => ''],   
                'pluginOptions'=>[
                
                    'depends'=>['cliente'],
                    'placeholder' => 'Select...',
                    'url'=>Url::to(['cliente/listado']),
                    //'params'=>['input-type-1', 'input-type-2']
                ]
            ]);


            }


    ?>
    
        <?php

           if(isset($actualizar)){

    ?>

            <input type="text" class=" form-control" value="<?= $model->novedad->nombre?>" disabled/>
    <?php
             


           }else{

                 
      echo $form->field($model, 'novedad_id')->widget(Select2::classname(), [
            'data' => $data_novedad,
            'options' => [

               'id' => 'tipo-visita',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); 
		}

           
           ?>

   <div class="row">
     
     
        <?php
          $nombre_usuario = '';
          $email_usuario = '';
          if(isset($usuario_model)){
            
            $nombre_usuario = $usuario_model->nombres.' '.$usuario_model->apellidos;
            $email_usuario = $usuario_model->email;          
            
          }
        ?>

     <div class="col-md-6">
            
            <?php 
               if(isset($actualizar)){
                 echo $form->field($model, 'contacto')->textInput(['maxlength' => true,'disabled' => 'disabled']); 
               }else{
                 
                 // Child # 2
                    echo $form->field($model, 'contacto')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data' => [1 => ''],   
                        'pluginOptions'=>[
                        
                            'depends'=>['cliente', 'sucursal'],
                            'placeholder' => 'Select...',
                            'url'=>Url::to(['cliente/listado2']),
                            //'params'=>['input-type-1', 'input-type-2']
                        ]
                    ]);
                 //echo $form->field($model, 'contacto')->textInput(['maxlength' => true]);
               }
            
            ?> 
             
            
            
            <?php
              
              if(isset($actualizar)){
                
                echo $form->field($model, 'vigilante')->textInput(['maxlength' => true, 'disabled' => 'disabled']);
                
              }else{
                
                echo $form->field($model, 'vigilante')->widget(Select2::classname(), [
                      'data' => $data_empleados,
                      'pluginOptions' => [
                          'allowClear' => true
                      ],
                  ]); 
          
                
              }
                
          
            ?>

            
            <?php
            
               if(isset($actualizar)){
                   echo $form->field($model, 'email_cliente')->textInput(['maxlength' => true, 'disabled' => 'disabled']);      
               }else{
                  echo $form->field($model, 'email_cliente')->textInput(['maxlength' => true]); 
               }
            ?>
            
                     
            <?php
               if(isset($actualizar)){
                   echo $form->field($model, 'reporta')->textInput(['maxlength' => true, 'disabled' => 'disabled']);      
               }else{
                  echo $form->field($model, 'reporta')->textInput(['maxlength' => true, 'value' => $nombre_usuario]); 
               }
            ?>
           
       

     </div>

     <div class="col-md-6">

         <?php
               if(isset($actualizar)){
                   echo $form->field($model, 'cargo')->textInput(['maxlength' => true, 'disabled' => 'disabled']);      
               }else{
                  echo $form->field($model, 'cargo')->textInput(['maxlength' => true]); 
               }
         ?>

         <?php
               if(isset($actualizar)){
                   echo $form->field($model, 'telefono')->textInput(['maxlength' => true, 'disabled' => 'disabled']);      
               }else{
                  echo $form->field($model, 'telefono')->textInput(['maxlength' => true]); 
               }
         ?>      
        
            <?php
               if(isset($actualizar)){
                   echo $form->field($model, 'email_reportante')->textInput(['maxlength' => true, 'disabled' => 'disabled']);      
               }else{
                  echo $form->field($model, 'email_reportante')->textInput(['maxlength' => true, 'value' => $email_usuario]); 
               }
            ?>
      
       

     </div>
    

   </div>
  
   <div class="row <?php if(!isset($actualizar)){echo 'hidden';}  ?>" id="detalle-tecnica">
       
     <!---- $Model2 Inicio-->   
        
      <?php  if($model2 != null):?>

        <div class="row">

           <div class="col-md-4">

             <h5>Puestos</h5>
             

           </div>

           <div class="col-md-4">


           <label class="control-label">Presentación de los vigilantes</label></br></br>
           <label class="control-label">Estado de la minuta</label></br></br>
           <label class="control-label">Estado del armamento</label></br></br>
           <label class="control-label">Estado de los equipos de comunicación</label></br></br>
           <label class="control-label">Estado de otros equipos de seguridad</label>
             

           </div>

           <div class="col-md-4">

            <?= $form->field($model2, 'presentacion')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

                  <?= $form->field($model2, 'minuta')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

                  <?= $form->field($model2, 'armamento')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

                  <?= $form->field($model2, 'equipos_seguridad')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

                  <?= $form->field($model2, 'equipos_comunicacion')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>      

             

           </div>

   

          
        </div>

        <div class="row">


        <div class="col-md-4">

             <h5>Riesgos Instalaciones</h5>
             

           </div>

           <div class="col-md-4">
          <label class="control-label">Iluminación</label></br></br>
           <label class="control-label">Control de Accesos</label></br></br>
           <label class="control-label">Seguridad Perimetral</label></br></br>
           <label class="control-label">Cerraduras</label>
           
             

           </div>

           <div class="col-md-4">

           <?= $form->field($model2, 'iluminacion')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>
           <?= $form->field($model2, 'acceso')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

           <?= $form->field($model2, 'perimetro')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

           <?= $form->field($model2, 'cerraduras')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>


           </div>


     
        </div>

        <div class="row">

         <div class="col-md-4">

             <h5>Consignas</h5>
             

           </div>

           <div class="col-md-4">

           <label class="control-label">Consignas Generales</label></br></br>
           <label class="control-label">Consignas Particulares</label></br></br>
           <label class="control-label">Instrucciones Especificas</label></br></br>
           
                     

           </div>

           <div class="col-md-4">
           <?= $form->field($model2, 'consigna_general')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

           <?= $form->field($model2, 'consigna_particular')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

    <?= $form->field($model2, 'instrucciones')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

  
           </div>

          
        </div>

        <div class="row">

          <div class="col-md-4">

             <h5>Seguridad Electrónica</h5>
             

           </div>

           <div class="col-md-4">


           <label class="control-label">Alarmas</label></br></br>
           <label class="control-label">CCTV</label></br></br>
           <label class="control-label">Otros equipos</label></br></br>
           <label class="control-label">Seguridad Industrial</label>
             

           </div>

           <div class="col-md-4">
            <?= $form->field($model2, 'alarmas')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

            
    <?= $form->field($model2, 'cctv')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

    <?= $form->field($model2, 'otros')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

    <?= $form->field($model2, 'seguridad_industrial')->radioList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala','N' => 'No Aplica'])->label(false) ?>

  <!----- Fin $model2 ------>
     <?php endif;?>
  
      </div>

          
        </div>

   </div>

   <?php
     if(isset($actualizar)){
            echo $form->field($model, 'comentarios')->widget(Summernote::className(), [
                      'options' => ['disabled' => 'disabled']
                   ]);      
         }else{
             echo $form->field($model, 'comentarios')->widget(Summernote::className(), [
                      
          ]); 
         }
    ?>
    <?php
        if(isset($actualizar)){
            echo $form->field($model, 'recomendaciones')->widget(Summernote::className(), [
                      'options' => ['disabled' => 'disabled']
                   ]);      
         }else{
             echo $form->field($model, 'recomendaciones')->widget(Summernote::className(), [
                      
          ]); 
         }
     ?>     
           
    <div class="row">

      <div class="col-md-6">
      <?php
               if(isset($actualizar)){
                   echo $form->field($model, 'compromiso_colviseg')->widget(Summernote::className(), [
                      'options' => ['disabled' => 'disabled']
                   ]);      
               }else{
                  echo $form->field($model, 'compromiso_colviseg')->widget(Summernote::className(), [
                      
                   ]); 
               }
       ?>
            

      </div>

      <div class="col-md-6">
      
       <?php
              if(isset($actualizar)){
                   echo $form->field($model, 'compromiso_cliente')->widget(Summernote::className(), [
                      'options' => ['disabled' => 'disabled']
                   ]);      
               }else{
                  echo $form->field($model, 'compromiso_cliente')->widget(Summernote::className(), [
                      
                   ]); 
               }
       ?>
            

      </div>
     
     

   </div>


      <?= Html::activeHiddenInput($model, 'estado_id',['value' => $estado[0]['id']])?>

 <div>
      
     <?php if(isset($observaciones) && count($observaciones) > 0):?>
        
        <h3>Observaciones</h3>
         <table class="table">
           
           <thead>
              
              <tr>
               <th>Elemento</th>
               <th>Soporte</th>
               <th>Descripción</th>
                
              </tr>
             
            </thead>
            
            <tbody>
              
              <?php foreach($observaciones as $key):?>
              <?php
                 $ruta = $key->archivo == null ? ' ' : $key->archivo;
                 $ruta = Yii::$app->request->baseUrl.$ruta; 
              ?>
              
                  <tr>
                     
                    <td><?= $key->elemento?></td>
                    <td><img alt="imagen" class="img-responsive img-thumbnail" src="<?= $ruta ?>" /></td>
                            
                    <td><?=$key->descripcion?></td>      
                  
                  </tr>
              
              <?php endforeach;?>
              
             </tbody>
           
         </table>
     
     <?php endif;?>
     
     
     
 </div>

   


<?php if(isset($flag)):?>
    
    <?php if($flag == 's'):?>
    
       <?php if(isset($actualizar)):?>

          
          <?php


            echo $form->field($model, 'usuario')->widget(Select2::classname(), [
                  'data' => $data_usuarios,
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ]); 


         ?>



          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
          </div>
         
          <div class="form-group">

            <?= Html::a('<i class="fa fa-eye"></i> Seguimientos',Yii::$app->request->baseUrl.'/seguimiento-visita/index?id='.$model->id,['class'=>'btn btn-primary']) ?>
            <?= Html::submitButton('Cerrar', ['class' =>  'btn btn-primary', 'name' => 'cerrar']) ?>
            <?php if(in_array("publicar", $permisos)):?>

              <?= Html::submitButton('Publicar', ['class' =>  'btn btn-primary','name' => 'publicar']) ?>

            <?php endif;?>
          
          
          </div>


         <?php endif;?>  
     <?php else:?>

      <?php


            echo $form->field($model, 'usuario')->widget(Select2::classname(), [
                  'data' => $data_usuarios,
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ]); 


         ?>



          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
          </div>
         
          <div class="form-group">


     <?php endif;?>

   <?php endif;?>

    <?php ActiveForm::end(); ?>

</div>

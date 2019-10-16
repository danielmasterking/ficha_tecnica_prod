<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}

$data_novedades = array();

foreach ($novedades as $value) {

    $data_novedades[$value->id] = $value->nombre;
}


?>
<!-- <nav class="navbar navbar-default" role="navigation">
 
  <div class="navbar-header">

  </div>
 
  <div class="collapse navbar-collapse navbar-ex1-collapse">

 
    <ul class="nav navbar-nav navbar-right">


      <?php if(isset(Yii::$app->session['usuario'])):?>
        <li>
             <?php
                
                echo Html::a('<i class="fa fa-lock"></i> Cambiar Clave',Yii::$app->request->baseUrl.'/site/cambio');
               

             ?>
        </li>
        <li><a href="#"> Bienvenido, <strong><?= Yii::$app->session['usuario']?></strong></a></li>
      <?php endif;?>
      
    </ul>
  </div>
</nav> -->


        <!-- <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                
              <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php if(in_array("clientes", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-user fa-fw"></i>Clientes',Yii::$app->request->baseUrl.'/cliente/index');?></li>
               <?php endif;?>
               <?php if(in_array("empleados", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-suitcase fa-fw"></i>Empleados',Yii::$app->request->baseUrl.'/site/empleados');?></li>
               <?php endif;?>
               <?php if(in_array("reporte diario", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Reporte Diario',Yii::$app->request->baseUrl.'/reporte-diario-enc/index');?></li>
               <?php endif;?>
                <?php if(in_array("visita tecnica", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Visita Técnica',Yii::$app->request->baseUrl.'/visita/index');?></li>
               <?php endif;?>
               <?php if(in_array("usuarios", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
               <?php endif;?>
               <?php if(in_array("ciudades", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-flag fa-fw"></i>Ciudades',Yii::$app->request->baseUrl.'/ciudad/index');?></li>
               <?php endif;?>
               <?php if(in_array("ccosto", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>CCostos',Yii::$app->request->baseUrl.'/ccosto/index');?></li>
               <?php endif;?>
               <?php if(in_array("novedades", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Novedades',Yii::$app->request->baseUrl.'/novedad/index');?></li>
               <?php endif;?>
               <?php if(in_array("estados", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Estados',Yii::$app->request->baseUrl.'/estado/index');?></li>
               <?php endif;?>
               <?php if(in_array("roles", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Roles',Yii::$app->request->baseUrl.'/rol/index');?></li>
               <?php endif;?>
               <?php if(in_array("permisos", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Permisos',Yii::$app->request->baseUrl.'/permiso/index');?></li>
               <?php endif;?>
                <?php if(in_array("indicadores", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Indicadores',Yii::$app->request->baseUrl.'/site/indicadores');?></li>
               <?php endif;?>
               <?php if(in_array("juntas", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Juntas',Yii::$app->request->baseUrl.'/junta/index');?></li>
               <?php endif;?>
               <?php if(in_array("armamento", $permisos)):?>
               <li class="active"><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Armas',Yii::$app->request->baseUrl.'/arma/index');?></li>
               <?php endif;?>
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>                
  
            </ul>
        </div>   -->
<div class="col-md-12">
<div class="preaviso-form check-form">

<!-- Validar permiso de administración de armas para poder moodificar datos básicos -->
  <?php if(in_array("adm-armas", $permisos)):?>
    <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" ><?php echo Html::a('Tipos',Yii::$app->request->baseUrl.'/tipo-arma/index'); ?></li>
     <li role="presentation" ><?php echo Html::a('calibre',Yii::$app->request->baseUrl.'/calibre/index'); ?></li>
     <li role="presentation" ><?php echo Html::a('Permiso Arma',Yii::$app->request->baseUrl.'/permiso-arma/index'); ?></li>
     <li role="presentation" class="active"><?php echo Html::a('Armas',Yii::$app->request->baseUrl.'/arma/index'); ?></li>
     <li role="presentation" ><?php echo Html::a('Mover Armas',Yii::$app->request->baseUrl.'/arma/trasladar'); ?></li>
   </ul>
     
   </div>
  <?php endif;?>

<!-- fin de validación de permisos de administración de armas -->



<div>


   <?php $form = ActiveForm::begin(); ?>
   <div class="form-group">

<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/arma/index',['class'=>'btn btn-primary']) ?>
  <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary pull-right']) ?>   
</div>
    <?= $form->field($historico_model,'arma_id')->hiddenInput(['value' => $arma ])->label(false)?>
    <?= $form->field($historico_model,'usuario')->hiddenInput(['value' => $usuario ])->label(false)?>

    <p></p>

    <?php if(isset($ok) && $ok === "200"):?>
       
       <div class="alert alert-success">
            Novedad agregada satisfactoriamente.
       </div>
      
    <?php endif;?>

    <div>

      <div class="form-group">
       <?php
        echo $form->field($historico_model, 'fecha')->widget(DateControl::classname(), [
        'displayFormat' => 'php:d-M-Y',
        'type'=>DateControl::FORMAT_DATE
         ]);
        ?>
    </div>
    
    <div class="form-group">
      <?=
        $form->field($historico_model, 'novedad_id')->widget(Select2::classname(), [
        'data' => $data_novedades,

        ])
      ?>
    </div>

    <div class="form-group">
      <?= $form->field($historico_model,'observacion')->textArea(['rows' => '6'] )?>
    </div>


    </div>


    <h3 style="text-align: center;">Detalle Arma </h3> 

    <div class="form-group">
      <div class="table-responsive"> 
      <table class="table">

        <thead>

          <tr>

            <th>Tipo</th>
            <th>Calibre</th>
            <th>Serie</th>
            <th>Permiso</th>
            <th>Fecha Vencimiento</th>
            <th>Ubicación</th>
            <th>Documento</th>

          </tr>

        </thead>

        <tbody>

          <tr>

            <td><?= $arma_model->tipo->nombre ?></td>
            <td><?= $arma_model->calibre->nombre ?></td>
            <td><?= $arma_model->serie ?></td>
            <td><?= $arma_model->permiso->nombre ?></td>
            <td><?= $arma_model->vencimiento ?></td>
            <td><?php

                if($arma_sucursal == null){

                  echo "Sin Asignar";

                }else{

                   echo $arma_sucursal->sucursal->nombre;
                }

            ?></td>
            <td></td>
          </tr>


        </tbody>

      </table>
        </div>
    </div>
     
    <h4>Registros Agregados</h4> 

    <div class="table-responsive"> 
    <table class="table display my-data" data-page-length='50' cellspacing="0">
     <thead>

      <tr>
         <th>Fecha</th>
         <th>Novedad</th>
         <th>Usuario</th>
         <th>Observación</th>
      </tr>

     </thead>

     <tbody>

      <?php foreach($historico as $key):?>
          <tr>

            <td><?= $key->fecha ?></td>
            <td><?= $key->novedad->nombre ?></td>
            <td><?= $key->usuario ?></td>
            <td><?= $key->observacion ?></td>

          </tr>
        
      <?php endforeach;?>

     </tbody>

    </table>
    </div>
    

    <?php ActiveForm::end(); ?>



</div>
    
   

</div>
</div>


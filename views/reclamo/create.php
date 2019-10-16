<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Reclamo */

$rol = '';

if (isset(Yii::$app->session['rol'])) {
    
    $rol = Yii::$app->session['rol']; 

}
?>
<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                
                <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php

                 if($rol == 'Administrador' || $rol == 'Recursos'){
               ?>
                <li ><?php echo Html::a('<i class="fa fa-file-pdf-o fa-fw"></i>Cartas',Yii::$app->request->baseUrl.'/preaviso/index');?></li>
               <li ><?php echo Html::a('<i class="fa fa-cloud-upload fa-fw"></i>Adjuntos',Yii::$app->request->baseUrl.'/adjunto/create');?></li>
               <li class="active" ><?php echo Html::a('<i class="fa fa-list fa-fw"></i>Reclamos Nómina',Yii::$app->request->baseUrl.'/reclamo/index');?></li>
               <?php
                     }
               ?>
       
                <li ><?php echo Html::a('<i class="fa fa-check fa-fw"></i>Prorrogas',Yii::$app->request->baseUrl.'/prorroga/index');?></li>
               
               <?php

                 if($_SESSION['rol'] == 'Administrador'){
               ?>
                <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
                <li ><?php echo Html::a('<i class="fa fa-flag fa-fw"></i>Ciudades',Yii::$app->request->baseUrl.'/ciudad/index');?></li>
               <?php
                     }
               ?>
                <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>
                
            </ul>
        </div>  
<div class="col-md-10 well">
<div class="preaviso-form check-form">

<div class="reclamo-create">

    <h1 style="text-align: center;">Reclamos de Nómina</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'empleados' => $empleados,
    ]) ?>

</div>

</div>
</div>
</div>
</div>



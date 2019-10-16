<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$empleados = isset($empleados) ? $empleados : '';
$retirados = isset($retirados) ? $retirados : '';

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}

//$this->title = 'Exito';
?>
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
	 <li role="presentation" class="<?= $empleados ?>"><?php echo Html::a('Empleados',Yii::$app->request->baseUrl.'/site/empleados'); ?></li>
	  <?php if(in_array("lista-negra", $permisos)):?>
     <li role="presentation" class="<?= $retirados ?>"><?php echo Html::a('Empleados Retirados',Yii::$app->request->baseUrl.'/site/empleados-retirados'); ?></li>
     <?php endif;?>
     
   </ul>
     
   </div>
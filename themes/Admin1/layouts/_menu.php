 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($sucursales);

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}
$controller=Yii::$app->controller->id;
$action=Yii::$app->controller->action->id;

?>

 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $this->theme->baseUrl; ?>/dist/img/logocvsc.PNG" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= Yii::$app->session['usuario']?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

        </div>
      </div>
      <!-- search form -->
     <!--  <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
       
        
        <li class="<?= $action=='home'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/site/home'?>">
        		<i class="fa fa-home fa-fw"></i> <span>Home</span>
        	</a>
        </li>
        <?php if(in_array("clientes", $permisos)):?>
        <li class="<?= $controller=='cliente'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/cliente/index'?>">
        		<i class="fa fa-user fa-fw"></i> <span>Clientes</span>
        	</a>
        </li>
        <?php endif;?>

        <?php if(in_array("empleados", $permisos)):?>
        <li class="<?= $action=='empleados'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/site/empleados'?>">
        		<i class="fa fa-suitcase fa-fw"></i> <span>Empleados</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("reporte diario", $permisos)):?>
        <li class="<?= $controller=='reporte-diario-enc'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/reporte-diario-enc/index'?>">
        		<i class="fa fa-users fa-fw"></i> <span>Reporte Diario</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("visita tecnica", $permisos)):?>
        <li class="<?= $controller=='visita'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/visita/index'?>">
        		<i class="fa fa-users fa-fw"></i> <span>Visita Técnica</span>
        	</a>
        </li>
        <?php endif;?>

        <?php if(in_array("usuarios", $permisos)):?>
        <li  class="<?= $controller=='usuario'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/usuario/index'?>">
        		<i class="fa fa-users fa-fw"></i> <span>Usuarios</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("ciudades", $permisos)):?>
        <li class="<?= $controller=='ciudad'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/ciudad/index'?>">
        		<i class="fa fa-flag fa-fw"></i> <span>Ciudades</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("ccosto", $permisos)):?>
        <li class="<?= $controller=='ccosto'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/ccosto/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>CCostos</span>
        	</a>
        </li>
        <?php endif;?>

        <?php if(in_array("novedades", $permisos)):?>
         <li class="<?= $controller=='novedad'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/novedad/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Novedades</span>
        	</a>
        </li>
        <?php endif;?>

        <?php if(in_array("estados", $permisos)):?>
        <li class="<?= $controller=='estado'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/estado/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Estados</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("roles", $permisos)):?>
        <li class="<?= $controller=='rol'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/rol/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Roles</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("permisos", $permisos)):?>
        <li class="<?= $controller=='permiso'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/permiso/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Permisos</span>
        	</a>
        </li>
        <?php endif;?>
        <?php if(in_array("indicadores", $permisos)):?>
        <li class="<?= $action=='indicadores'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/site/indicadores'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Indicadores</span>
        	</a>
        </li>
        <?php endif;?>

        <?php if(in_array("juntas", $permisos)):?>
        <li class="<?= $controller=='junta'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/junta/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Juntas</span>
        	</a>
        </li>
        <?php endif;?>

        <?php if(in_array("armamento", $permisos)):?>
        <li class="<?= $controller=='arma'?'active':'' ?>">
        	<a href="<?= Yii::$app->request->baseUrl.'/arma/index'?>">
        		<i class="fa fa-dot-circle-o fa-fw"></i> <span>Armas</span>
        	</a>
        </li>
       <?php endif;?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

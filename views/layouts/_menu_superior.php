<?php 

use yii\helpers\Html;
?>
<nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">

  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">

 
    <ul class="nav navbar-nav navbar-right">


      <?php if(isset(Yii::$app->session['usuario'])):?>
      	<li class="dropdown">
          <a data-toggle="tooltip" data-placement="bottom" id='title_curso' href="<?=Yii::$app->request->baseUrl.'/site/notificacion_cursos'?>" >
           <!--  <i class="fa fa-bell"></i>  -->
           <img id="not_icon" height="25px">
            <span class="badge badge-info" id="cursos_cant"></span>   <!-- <span class="caret"></span> -->
          </a>
          <!-- <ul class="dropdown-menu" id="cursos_not">
          	<li>
          		
          		<input type="text" id="buscar_curso">
          	</li> -->

            <!-- <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li> -->
          <!-- </ul> -->
        </li>
        <li>
             <?php
                
                echo Html::a('<i class="fa fa-lock"></i> Cambiar Clave',Yii::$app->request->baseUrl.'/site/cambio');
               

             ?>
        </li>
        <li><a href="#"> Bienvenido, <strong><?= Yii::$app->session['usuario']?></strong></a></li>
      <?php endif;?>
      
    </ul>
  </div>
</nav>

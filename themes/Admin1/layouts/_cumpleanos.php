<?php 
	use app\models\UsuarioCliente;
	date_default_timezone_set ( 'America/Bogota');
        $fecha = date('Y-m-d',time());
    	$clientes_asignados = UsuarioCliente::find()->where(['usuario' => Yii::$app->session['usuario']])->all();
        $sucursales = array();
        $contactos_temp = array();
        $contactos = array();
        $cumpleano_time = strtotime('+3 day' , strtotime ( $fecha ));
        $today_time = strtotime($fecha);
        foreach($clientes_asignados as $key){

          $sucursales = $key->cliente->sucursales;

          foreach ($sucursales as $key2 ) {

              $contactos_temp = $key2->contactos;

              foreach ($contactos_temp as $key3) {

                  if( (strtotime($key3->cumpleano) <= $cumpleano_time) && strtotime($key3->cumpleano) >= $today_time ) {

                    $contactos [] = $key3;

                  }
              }




          }



        }


        $cantidad_contactos=count($contactos);


?>
<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?= $cantidad_contactos ?> Personas Cumplen años">
  <i class="fa fa-birthday-cake"></i>
  <span class="label label-success"><?= $cantidad_contactos ?></span>
</a>
<ul class="dropdown-menu">
  <li class="header"><?= $cantidad_contactos ?> Cumpleaños</li>
  <li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
      <?php foreach($contactos as $key):?>
      <li><!-- start message -->
        <a href="#">
          <div class="pull-left">
            <img src="<?php echo $this->theme->baseUrl; ?>/dist/img/Birthday-80_icon-icons.com_57369.png" class="img-circle" alt="User Image">
          </div>
          <h4>
            <?= $key->nombres.' '.$key->apellidos;?>
           
          </h4>
          <p>contacto de la sucursal <?= $key->sucursal->nombre;?> </p>
        </a>
      </li>
      <!-- end message -->
  <?php endforeach;?>
    </ul>
  </li>
  <li class="footer"><a href="#">Feclicidades a todos</a></li>
</ul>
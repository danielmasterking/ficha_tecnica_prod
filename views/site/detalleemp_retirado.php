<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Hdv_tercero;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($sucursales);

$consulta_hv=Hdv_tercero::find()->where(' id_tercero='.$empleado[0]['CEDULA'])->one();

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}



?>



        <!-- <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                
               <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php if(in_array("clientes", $permisos)):?>
               <li class="active"><?php echo Html::a('<i class="fa fa-user fa-fw"></i>Clientes',Yii::$app->request->baseUrl.'/cliente/index');?></li>
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
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Armas',Yii::$app->request->baseUrl.'/arma/index');?></li>
               <?php endif;?>
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/salir');?></li>                
              
            </ul>
        </div>  --> 
<div class="col-md-12">
<div class="preaviso-form check-form">
   
   
<div class="form-group">

<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/site/empleados-retirados',['class'=>'btn btn-primary']) ?>

</div>   

<h3 style="text-align: center;">Información Empleado Retirado</h3>

<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<p>&nbsp;</p>
<div class="row">

<div class="col-md-6">

<p ><strong>Cedula:</strong> <?= $empleado[0]['CEDULA']?></p>
<p ><strong>Nombre:</strong> <?= $empleado[0]['NOMBRE']?></p>
<p ><strong>Dirección:</strong> <?= $empleado[0]['DIRECCION']?></p>
<p ><strong>Teléfono:</strong> <?= $empleado[0]['TELEFONO']?></p>
<p ><strong>Ciudad:</strong> <?= $empleado[0]['UBICACION']?></p>


</div>

<div class="col-md-6">


<p ><strong>Fecha ingreso:</strong> <?= $empleado[0]['INGRESO']?></p>
<p ><strong>Hoja de vida:</strong> 

<?php if(!$consulta_hv==null):?>
  <a target='_blank' href="<?= Yii::$app->request->baseUrl.$consulta_hv->hoja_vida ?>"><i class="fa fa-file-archive-o" ></i> HV</a>

<?php else: ?>

  <span class="text-danger">No adjunto</span>

<?php endif;?>
</p>
 




</div>

<p>&nbsp;</p>

  

</div>

<div class="form-group">
		<?php 
		echo $form->field($AuditoriaRetirados, 'motivo')->dropDownList(
			[
				'DD' => 'Discrecionalidad directiva', 
				'MD' => 'Motivos disciplinarios',
				'R' => 'Renuncia',
			],
			['prompt'=>'Select...','onchange'=>'validar(this);','id'=>'motivo']
	 	); ?>



</div>

<div class="form-group">

	<?php 
		$estado=$AuditoriaRetirados->estado=='N'?true:false;

		echo $form->field($AuditoriaRetirados, 'estado')->dropDownList(
			['A' => 'Apto', 'N' => 'No Apto'],
			['prompt'=>'Select...','id'=>'estado','disabled'=>$estado]
	 	); ?>
</div>

<div class="form-group">
	<?= $form->field($AuditoriaRetirados, 'observacion')->textarea(['rows'=>'5']); ?>
</div>
<br>
<button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
<br>
<br>
<?php ActiveForm::end(); ?>


  <!-- ************************************************************** -->
  <div class="panel panel-primary">
    <div class="panel-heading">Novedades de Retiros</div>
    <div class="panel-body">
        <div class="table-responsive"> 
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Numero Novedad</th>    
              <th>Nombre Novedad</th>
              <th>Motivo</th>
              <th>Fecha Novedad</th>
              <th>Observacion Novedad</th>
              <th>Numero Liq. Novedad </th>
              
            </tr>    
          </thead>
          <tbody>
            <?php 
            foreach($novedad as $nov):
              
            ?>
            <tr>
           
              <td><?php echo  $nov['novn_numero']; ?></td>
              <td><?php echo  $nov['conc_nombre']; ?></td>
              <td><?php echo  $nov['motivo']==''?'-':$nov['motivo']; ?></td>
              <td><?php echo  date("d/m/Y ",strtotime($nov['novf_fecha'])) ; ?></td>
              <td><?php echo  $nov['novt_observacion']==''?'-':$nov['novt_observacion']; ?></td>
              <td><?php echo  $nov['Liquidacion']==''?'-':$nov['Liquidacion']; ?></td>
            

            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        </div>
    </div>
  </div>
  <!-- ************************************************************** -->
</div>
</div>



<script type="text/javascript">


function validar(objeto){
	var valor=$(objeto).val();
	switch(valor) {
	    case 'DD':
	       $("#estado option[value=N]").attr({"selected":true});
	       $("#estado ").attr({"disabled":true,});
	        break;
	    case 'MD':
	        $("#estado option[value=N]").attr({"selected":true});
	        $("#estado ").attr({"disabled":true,});
	        break;
	    default:
	        $("#estado").removeAttr('disabled');
	}

}

  function open_certificado(url){

    url='../../../'+url;
    window.open(url, "_blank");
  }

 

</script>






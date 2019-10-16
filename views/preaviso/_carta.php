<?php
/* @var $this yii\web\View */
  $default = Yii::$app->request->baseUrl. '/img/firma_preaviso.png';
  $logo = Yii::$app->request->baseUrl. '/img/cvsc.png';
  $ciudad = ucfirst(strtolower($ciudad));

  

?>


<?php
  
  foreach ($preavisos as $key => $value) {
?>

   <img  style="float:left;" alt="firma" src="<?=$logo?>" width="100" height="100" /> 	
   
      <h4 style="float:left;"> COLVISEG DEL CARIBE LIMITADA 
                              <!-- Colombiana de Vigilancia y Seguridad del Caribe Ltda -->
      </h4>
      	
  

</br>
</br>
</br>

<div style="text-align:justify;clear:both;margin-top:40px;">

<h5><?=$ciudad?>, <?=$fecha?> </h5>

</br>
</br>
</br>
<p>Señor(a):</p>
</br>
<p><?=$value['terc_nombre']?></p>
<p>C.C No. &nbsp;&nbsp;<?=$value['terc_nit']?></p>
<p>Ciudad</p>

</br>
</br>
<p>
  &nbsp;
</p>
<p>Respetado Colaborador:</p>
</br>
<p>
	Por medio de la presente le recordamos que el contrato de trabajo</br>
	pactado con usted vence el día <strong><?=$value['terf_contrato']?></strong> por lo que le estamos preavisando
	para que a partir de esa fecha entregue los uniformes
	y demas implementos que le fueron entregados para la realización de sus funciones.
</p>
</br>
<p>
	Para lo relacionado con la liquidación de las Cesantías y Prestaciones
	sociales puede usted pasar por las oficinas de Colviseg del Caribe Ltda,
	previo tramite de su paz y salvo.
</p>
<p>
  &nbsp;
</p>
</br>
</br>
</br>
</br>
<p>Cordialmente,</p>
</br>
</br>
<p>
   <img alt="firma" src="<?=$default?>" width="200" height="80" />
</p>
</br>
<p>Yaneth Turriago Duarte</p>
<p>Gerente Nacional De Talento Humano</p>
</br>
</br>
<p>C.C Hoja de Vida</p>
</br>

</div>

<pagebreak />


<?php
  }

?>




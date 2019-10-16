<?php
/* @var $this yii\web\View */
  $default = Yii::$app->request->baseUrl. '/img/firma_preaviso.png';


?>


<?php
  
  foreach ($preavisos as $key => $value) {
?>

<h3>COLVISEG DEL CARIBE LIMITADA</h3>
<h4>Colombiana de Vigilancia y Seguridad del Caribe Ltda</h4>

</br>
</br>
</br>

<h4>Barranquilla, <?=$fecha?> </h4>

</br>
</br>
</br>
<p>Señor(a):</p>
</br>
<p><?=$value['terc_nombre']?></p>
<p>C.C No. &nbsp;&nbsp;<?=$value['terc_nit']?></p>
<p>Ciudad</p>
</br>
<p>---------</p>
</br>
</br>
<p>Respetado Colaborador:</p>
</br>
<p>
	Por medio de la presente le recordamos que el contrato de trabajo</br>
	pactado con usted vence el día <?=$value['terf_contrato']?> _________ </br>
	por lo que le estamos preavisando para que a partir de esa fecha <br>
	entregue los uniformes y demas implementos que le fueron entregados</br>
	para la realización de sus funciones.
</p>
</br>
<p>
	Para lo relacionado con la liquidación de las Cesantías y Prestaciones </br>
	sociales puede usted pasar por las oficinas de Colviseg del Caribe Ltda, </br>
	previo tramite de su paz y salvo.
</p>
</br>
</br>
<p>Cordialmente,</p>
</br>
</br>
<p>
   <img alt="firma" src="<?=$default?>" width="200" height="80" />
</p>
</br>
<p>Director Regional De Talento Humano</p>
</br>
</br>
<p>C.C Hoja de Vida</p>
</br>
<p><strong>COLVISEG DEL CARIBE LTDA/SUPERVISORES</strong></p>

<pagebreak />


<?php
  }

?>




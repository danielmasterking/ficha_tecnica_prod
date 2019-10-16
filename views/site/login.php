<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use \kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
$this->title='Login'
?>

<div class="login-box-body" style="background-color:rgba(0,31,50,0.6) !important;border: 2px solid !important;">
    <center>
    	<img src="<?php echo $this->theme->baseUrl; ?>/dist/img/logocvsc.PNG" alt="..." class="img-circle img-responsive" style="height: 75px;width: 70px;">
    </center><br>

    <?php $form = ActiveForm::begin([
           'id' => 'login-form',
           'options' => ['class' => 'form-horizontal','role'=>'form'],
       ]); ?>
      <div class="form-group has-feedback" >
      	<input id="loginform-username" type="text" class="form-control" placeholder="Usuario" name="LoginForm[username]" required="">
        <?php 
        	//echo $form->field($model, 'username')->textInput(['class'=>'form-control','placeholder'=>'Usuario'])->label(false);
        ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
      	<input id="loginform-password" type="password" class="form-control" placeholder="Contraseña" name="LoginForm[password]" required="">
        <?php  
        	//echo $form->field($model, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'Usuario'])->label(false);
        ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4">

          <?= Html::submitButton('<i class="glyphicon glyphicon-log-in"></i> Ingresar', ['class' => 'btn btn-danger btn-block btn-flat', 'name' => 'login-button','style'=>'background-color: #99242c;']) ?>
        </div>
        <!-- /.col -->
      </div>
    <?php ActiveForm::end(); ?>

    

  </div>
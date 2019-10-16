<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use \kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

?>
<div class="container">
 <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
   <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Ingreso al Sistema</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"></div>
                    </div>
                    <div style="padding-top:30px" class="panel-body" >
                      <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                      <?php $form = ActiveForm::begin([
                                                       'id' => 'login-form',
                                                       'options' => ['class' => 'form-horizontal','role'=>'form'],
                                                   ]); ?>

                         <div style="margin-bottom: 10px;width:100%;" class="input-group">
                                        
                                        <?php

                                        echo $form->field($model, 'username', [
                                             'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-user"></i>']]
                                        ])->label(false);

                                        ?>
                                         
                                        

                                    </div>

                                       <div style="margin-bottom: 5px;width:100%;" class="input-group">
                                        
                                        <?php

                                        echo $form->field($model, 'password', [
                                             'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-lock"></i>']]
                                        ])->passwordInput()->label(false);

                                        ?>
                                         
                                        

                                    </div>

                                    <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                         
                                            <?= $form->field($model, 'rememberMe', [
                                                             'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                             ])->checkbox() ?>
                                        </label>
                                      </div>
                                    </div>

                                <div style="margin-top:5px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">

                                      <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                                    </div>
                                </div>



                       <?php ActiveForm::end(); ?>


                    </div>
   </div>
 </div>



    
    
    
</div>

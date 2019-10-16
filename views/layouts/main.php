<?php

if (Yii::$app->session->isActive){
    //$this->redirect(['site/index','flash' => 'La sessión actual ha terminado por favor ingrese nuevamente.']);
    //echo "session abierta";
}

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
    
    <header>
        
       <img class="img-responsive" style="width: 100%;height: 50%;" src="<?=Yii::$app->request->baseUrl.'/img/CVSCPORTADA.png'?>">
    </header>

            <?php if(isset(Yii::$app->session['usuario'])):?>
            <?php echo $this->render('_menu_superior'); ?>
            

            <?php endif;?>
            
            <?php echo $content; ?>

           
        
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Colviseg del Caribe <?= date('Y') ?> todos los derechos reservados</p>
            
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
    $( document ).ready(function() {

        //setInterval(function(){Push.create('Hello World!') }, 1000);

        cursos();

       // $('#title_curso').tooltip();
    });

    

    function cursos(){

        $.ajax({
            url:"<?php echo Yii::$app->request->baseUrl . '/site/num_cursos'; ?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {     
            },
            beforeSend:  function() {
                //$('#body_ayuda').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
                //alert(data.respuesta);
            success: function(data){

                $('#cursos_cant').html(data.result);

                if (data.result>0) {

                    $('#not_icon').attr({
                        src: '<?php echo Yii::$app->request->baseUrl . '/images/notificar.gif'; ?>'
                    });
                }else{

                    $('#not_icon').attr({
                        src: '<?php echo Yii::$app->request->baseUrl . '/images/notificacion.PNG'; ?>'
                    });
                }

                $('#title_curso').attr({
                    title: 'Hay '+data.result+' Cursos por vencerse',
                    
                });

                $('#title_curso').tooltip()

                <?php if(Yii::$app->session['notificacion']==1):?>
                    Push.create('Hay '+data.result+' Cursos por vencerse', {
                        body: "",
                        icon: 'http://www.autoescuelascostablanca.com/Content/Images/diary.gif',
                        //timeout: 5000,
                        onClick: function () {
                            //window.focus();
                            //this.close();
                            location.href='<?php echo Yii::$app->request->baseUrl . '/site/notificacion_cursos'; ?>'
                        }
                    });

                <?php   
                    Yii::$app->session['notificacion']=0;
                    endif;
                ?>
            }
        });

    }


    // function notificacion_cursos(){
    //     var buscar=$('#buscar_curso').val();
        
    //     $.ajax({
    //         url:"<?php //echo Yii::$app->request->baseUrl . '/site/notificacion_cursos'; ?>",
    //         type:'POST',
    //         dataType:"json",
    //         cache:false,
    //         data: {     
    //             buscar:buscar
    //         },
    //         beforeSend:  function() {
    //             //$('#body_ayuda').html('Cambiando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
    //         },
    //         success: function(data){
    //             //alert(data.respuesta);
                
    //            $('#cursos_cant').html(data.count);
    //            $('#cursos_not').html(data.html);
    //         }
    //     });
    // }
</script>


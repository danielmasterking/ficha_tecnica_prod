<?php
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
        
       <img class="img-responsive" style="width: 100%;height: 50%;" src="<?=Yii::$app->request->baseUrl.'/img/CVSCPORTADA1.png'?>">
    </header>



       
            
            <?= $content ?>
        
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

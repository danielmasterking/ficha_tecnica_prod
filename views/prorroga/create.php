<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prorroga */


?>
<div class="container" style="margin-top:50px;">



<div class="prorroga-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
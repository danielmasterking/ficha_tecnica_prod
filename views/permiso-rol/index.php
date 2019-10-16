<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PermisoRolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permiso Rols';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-rol-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Permiso Rol', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rol_id',
            'permiso_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoricoArmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historico Armas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-arma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Historico Arma', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'arma_id',
            'novedad_id',
            'fecha',
            'observacion',
            // 'usuario',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

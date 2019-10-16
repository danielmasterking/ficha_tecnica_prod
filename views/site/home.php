<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?php
/* @var $this yii\web\View */
$this->title = 'Home';
?>
<!-- Small boxes (Stat box) -->
<!-- Info Boxes Style 2 -->
<div class="row">
        <div class="col-md-3">
           <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-building"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Clientes Visitados</span>
              <span class="info-box-number"><?= $row_visita_cliente['TOTAL'] ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?= $porcentaje_visitas_cliente?>%"></div>
              </div>
              <span class="progress-description">
                    <?= $porcentaje_visitas_cliente?>% 
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
         
        <div class="col-md-3">
          <!-- /.info-box -->
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-list-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Visitas Tecnicas</span>
              <span class="info-box-number"><?= $row_visita_tecnica['TOTAL'] ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?= $porcentaje_visitas_tecnica?>%"></div>
              </div>
              <span class="progress-description">
                    <?= $porcentaje_visitas_tecnica?>% 
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        

        <div class="col-md-3">
           <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Inspecciones</span>
              <span class="info-box-number"><?= $num_inspecciones?></span>

              <div class="progress">
                <!-- <div class="progress-bar" style="width: 70%"></div> -->
              </div>
              <span class="progress-description">
                    <!-- 70% Increase in 30 Days -->
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        

        <div class="col-md-3">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-edit"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Capacitaciones</span>
              <span class="info-box-number"><?= $num_capacitacion?></span>

              <div class="progress">
                <!-- <div class="progress-bar" style="width: 40%"></div> -->
              </div>
              <span class="progress-description">
                    <!-- 40% Increase in 30 Days -->
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
          
</div>

<div class="row">

<div class="col-md-8 col-xs-12" >
   <!-- DONUT CHART -->
  <div class="box box-danger" >
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-sticky-note"></i> Novedades</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body" >
      <div id="pie"  ></div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

</div>

<div class="col-md-4 col-xs-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                <img class="img-circle" src="<?php echo $this->theme->baseUrl; ?>/dist/img/avatar5.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?= Yii::$app->session['usuario']?></h3>
              <h5 class="widget-user-desc">Colviseg Del Caribe</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#"><i class="fa fa-users"></i> Clientes <span class="pull-right badge bg-blue"><?= $clientes?></span></a></li>
                <li><a href="#"><i class="fa fa-industry"></i> Sucursales <span class="pull-right badge bg-aqua"><?= $num_sucursales?></span></a></li>
                <!-- <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li> -->
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->

         


           <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-book"></i> Info Cursos</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $num_cursos_expirados?></h3>

              <p>Cursos Vencidos</p>
            </div>
            <div class="icon">
              <i class="fa  fa-calendar-times-o"></i>
            </div>
            <a href="#" class="small-box-footer">
              Mas info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>


           <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $num_cursos ?></h3>

              <p>Cursos por vencer</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?= Yii::$app->request->baseUrl.'/site/notificacion_cursos'?>" class="small-box-footer">
              Mas info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
       

  </div>

</div>

<div class="row">
  <div class="col-md-12">
    <!-- *********************************** -->
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-bomb"></i>Inventario de Armas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           

              <div class="table-responsive">
                <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                  <?php $cont=0; foreach ($arreglo_armas as $key_arma => $value_arma) {?>
                  <div class="panel box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $cont?>">
                          <?= $key_arma?>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?= $cont?>" class="panel-collapse collapse">
                      <div class="box-body">
                        <div class="col-md-12">
                          <table class="table table-striped">
                            <tr>
                              <td colspan="2" style="text-align: center;">Tipos de Arma</td>
                            </tr>
                            <?php foreach ($value_arma as $key_total => $value_total) { ?>
                            <tr>
                              <td style="text-align: center;"><?=$key_total?>:</td>
                              <td style="text-align: center;"><?= $value_total?></td>
                            </tr>
                            <?php
                              }
                            ?>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php $cont++;}?>
                </div>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
            <!-- /.box-footer -->
          </div>
    <!-- *********************************** -->
  </div>
</div>

<script type="text/javascript">
  Highcharts.chart('pie', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'TOTAL:',
        data:<?= $json_novedades?>
    }]
});
       
</script>
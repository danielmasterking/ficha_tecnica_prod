<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'js/datatables-bootstrap/datatables.min.css',
        'js/datatables-bootstrap/Buttons-1.5.4/css/buttons.bootstrap.min.css',
        'css/bootstrap-toggle.min.css',
        //'css/site.css',
        //'css/main.css',
    ];
    public $js = [

      // 'js/jquery.dataTables.min.js',
       'js/datatables-bootstrap/datatables.min.js',
       'js/datatables-bootstrap/Buttons-1.5.4/js/buttons.bootstrap.min.js',
       'js/bootstrap-toggle.min.js',
       //'js/dataTable.tableTools.js',
       'js/main.js',
       'js/push.min.js',
       //'js/bootstrap.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

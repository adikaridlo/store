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
        // 'css/site.css',
        'theme/assets/global/plugins/font-awesome/css/font-awesome.min.css',
        'theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css',
        'theme/assets/global/plugins/bootstrap/css/bootstrap.min.css',
        'theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'theme/assets/global/css/components.min.css',
        'theme/assets/global/css/plugins.min.css',
        'theme/assets/layouts/layout/css/layout.min.css',
        'theme/assets/layouts/layout/css/themes/darkblue.min.css',
        'theme/assets/layouts/layout/css/themes/default.min.css',
        'theme/assets/layouts/layout/css/custom.min.css',
        'css/rbac/animate.css',
        'css/rbac/jquery-ui.css',
        'css/slider.css'
      
    ];
    public $js = [
        'theme/assets/global/plugins/jquery.min.js',
        'theme/assets/global/plugins/bootstrap/js/bootstrap.min.js',
        'theme/assets/global/plugins/js.cookie.min.js',
        'theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'theme/assets/global/plugins/jquery.blockui.min.js',
        // 'theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'theme/assets/global/scripts/app.min.js',
        'theme/assets/layouts/layout/scripts/layout.min.js',
        // 'theme/assets/layouts/layout/scripts/demo.min.js',
        'theme/assets/layouts/global/scripts/quick-sidebar.min.js',
        'theme/assets/layouts/global/scripts/quick-nav.min.js',
        'js/rbac/jquery-ui.js',
        'js/slider.js'

    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}

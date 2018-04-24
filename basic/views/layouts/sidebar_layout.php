<?php 
use app\components\rbac\MenuHelper;
use app\components\rbac\Helper;
use yii\bootstrap\Nav;
use app\models\MerchantRequest;
// use app\widgets\MenuWidget; 
use yii\widgets\Menu;
use yii\bootstrap\NavBar; 
use yii\helpers\Html; 
?>

<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px"> -->

        <?php 
            $callback = function($menu){

                $item      = Yii::$app->controller->action->id;
                // $data   = eval($menu['data']);
                $data      = json_decode($menu['data'], true);
                $icon      = isset($data['icon']) ? $data['icon'] : '';
                $accordion = !empty($menu['children']) ? '<span class="selected"></span><span class="arrow"></span>' : '';
                $navToogle = ($menu['route'] == '/#') ? 'nav-toggle' : '';
                // $merch     = MerchantRequest::find()->where(['not in', 'status', ['rejected', 'verified']])->count();
                $notif     = isset($data['notif']['count']) ? $data['notif']['count'] > 0 ? '<small class="label label-danger pull-right">'. $data['notif']['count'] .'</small>' : ''  : '';
                // $notif     = isset($data['notif']['count']) ? $merch > 0 ? '<small class="label label-danger pull-right">'. $merch .'</small>' : ''  : '';
                $notif     = \Yii::$app->user->identity->user_type == 'admin' ? $notif : '';
                // $hide = !(isset($data['hide']) ? ($data['hide'] == 1 ? true : false) : false);
                
                $hide = 1;

                /*
                    - ada 2 menu report, 1. report tanpa dropdown dan 2. report dengan dropdown
                    - tampilkan menu report tanpa dropdown jika yang login (merchant) dan
                    - tamilkan menu report dropdown jika super admin / admin 
                 */
                if ((isset($data['hide']) && $data['hide'] == 1)) {
                    if (Yii::$app->user->can('merchant') && Yii::$app->user->can('report_merchant')) {
                        if ($menu['route'] != '/#') {
                            $hide = 1;
                        } else $hide = 0;
                    }
                    elseif (Yii::$app->user->can('sub_merchant') && Yii::$app->user->can('qr_sub')) {
                        if ($menu['route'] != '/#') {
                            $hide = 1;
                        } else $hide = 0;
                    }
                     else {
                        if ($menu['route'] != '/#') {
                            $hide = 0;
                        } else $hide = 1;
                    }
                }

                return [
                    'label'    => $menu['name'],
                    'url'      => ($menu['route'] == '/#') ? 'javascript:;' : $menu['route'],
                    'option'   => $data,
                    'visible'  => $hide,
                    'icon'     => 'fa fa-dashboard',
                    'items'    => $menu['children'],
                    'template' => '<a href="{url}" class="nav-link '.$navToogle.'"><i class="'.$icon.'"></i> <span class="title">{label}</span>'.$notif.$accordion.'</a>',
                    // 'visible' => Yii::$app->user->can('role')
                ];
            };

            $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
            $items = Helper::filter($items);

            echo Menu::widget([ 
                'options' => [ 
                                "class"              => "page-sidebar-menu  page-header-fixed ", 
                                "data-keep-expanded" => "false", 
                                "data-auto-scroll"   => "true", 
                                "data-slide-speed"   => "200", 
                                "style"              => "padding-top: 20px"
                            ], 
                'encodeLabels'    => false,   
                // 'linkTemplate'    => '<a href="{url}"><i class="{icon}"></i><span class="title">{label}</span><span class="selected"></span></a>',
                'items'           => $items,
                'submenuTemplate' => "\n<ul class='sub-menu'>\n{items}\n</ul>\n",   
                'itemOptions'=>['class'=>'nav-item'],
            ]); 
        ?> 
        <!-- </ul> -->
    </div> 
</div> 

<?php 

$en = <<< JS

$(function(){
    var url = window.location;

    url = decodeURIComponent(url);

    $('li.nav-item a.nav-link').filter(function() {
        return this.href == url;
    }).closest('li.nav-item').addClass('active open')
        .closest('ul.sub-menu').closest('li.nav-item').addClass('active open')
        .find('.arrow').addClass('open');
});
JS;

$this->registerJs($en,  \yii\web\View::POS_END);

?>

<?php
// if ( Yii::$app->user->isGuest and Yii::$app->request->url != '/merchant/create' and Yii::$app->request->url != '/forgot-password/index' and substr(Yii::$app->request->url, 0,27) != '/forgot-password/input-code' and Yii::$app->request->url != '/forgot-password-otp/index' and Yii::$app->request->url != '/aggregator-request/create')
//     return Yii::$app->controller->redirect('/site/login');
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;


// AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

    <body class="page-header-fixed page-footer-fixed page-sidebar-closed-hide-logo page-content-white";>
    <?php $this->beginBody() ?>
        <div class="page-wrapper">
            <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/slide_layout')?>
            <div class="clearfix"> </div>
            <div class="page-container">
                    <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/sidebar_layout')?>
                <div class="page-content-wrapper">
                    <div class="page-content">

                        <div class="page-bar">
                            <?= Breadcrumbs::widget([
                                 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                 'options' => ['class' => 'page-breadcrumb'],
                                 'itemTemplate' => '<li>{link}<i class="fa fa-circle"></i></li>',
                            ]) ?>
                        </div>

                        <br>
                    <?= Alert::widget() ?>
                    <?php echo $content; ?>
                    </div>
                </div>
            </div>

            <div class="page-footer">
                <div class="page-footer-inner"> <?php echo date('Y');?> &copy; MOM
                     
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
        </div>
        <div class="quick-nav-overlay"></div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
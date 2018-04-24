<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- <?= Html::csrfMetaTags() ?> -->
    <title><?= Html::encode($this->title) ?></title>

    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>vendor/bootstrap/css/bootstrap.css">

    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>css/shop-homepage.css">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>css/shop-homepage.css">
     <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/node_modules/') ?>angular-material/angular-material.min.css">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/css/') ?>style.css">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/node_modules/') ?>angular-material/modules/closure/dialog/dialog-default-theme.min.css">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/node_modules/') ?>angular-material/modules/closure/dialog/dialog-default-theme.css">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/node_modules/') ?>angular-material/modules/closure/dialog/dialog.css">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/node_modules/') ?>angular-material/modules/closure/dialog/dialog.min.css">
</head>
<?php $this->beginBody() ?>
<body ng-app="MyApp" ng-controller="AppCtrl" class="md-padding" id="popupContainer" ng-cloak class="item-index" id="bg-content">
        <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/navigation');?>

    <div class="container">

      <div class="row">

        <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/category');?>

        <div class="col-lg-9">

          <!-- slide -->
          <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/slider');?>
          <?= $content ?>

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>

<?php echo Yii::$app->controller->renderPartial('@app/views/layouts/footer');?>
<!-- Bootstrap core JavaScript -->
    <script src="<?php echo Yii::getAlias('@web/template/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo Yii::getAlias('@web/template/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>$('input').attr('autocomplete','off');</script>
    <?php $this->endBody() ?>
<?php
    echo $this->registerJsFile("node_modules/angular/angular.js");
    // echo $this->registerJsFile("node_modules/angular/angular.min.js");
    echo $this->registerJsFile("node_modules/angular-animate/angular-animate.min.js");
    echo $this->registerJsFile("node_modules/angular-aria/angular-aria.min.js");
    echo $this->registerJsFile("node_modules/angular-messages/angular-messages.min.js");
    echo $this->registerJsFile("node_modules/angular-material/angular-material.min.js");
    echo $this->registerJsFile("node_modules/app.js");
    // echo $this->registerJsFile("node_modules/jquery.min.js");
  ?>
  </body>

</html>
<?php $this->endPage() ?>

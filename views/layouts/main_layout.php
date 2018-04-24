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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= /* Html::csrfMetaTags()*/ ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <?= /*Html::csrfMetaTags()*/ ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/template/')?>css/shop-homepage.css">
    <!-- ANGULAR -->

</head>
<body>
<?php $this->beginBody() ?>
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

<?php $this->endBody() ?>
<!-- Bootstrap core JavaScript -->
    <script src="<?php echo Yii::getAlias('@web/template/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo Yii::getAlias('@web/template/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
<?php $this->endPage() ?>

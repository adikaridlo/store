<?php
use yii\helpers\Html;
?>
<!-- navbar-fixed-top -->
<div class="page-header navbar">
    <div class="page-header-inner ">
      <div class="container">
        <div class="mySlides">
          <div class="numbertext">1 / 6</div>
          <?php echo Html::img(Yii::getAlias('@web/uploads/1.jpg'), ['width'=>'100%','height' => '300px']); ?>
        </div>

        <div class="mySlides">
          <div class="numbertext">2 / 6</div>
          <?php echo Html::img(Yii::getAlias('@web/uploads/2.jpg'), ['width'=>'100%','height' => '300px']); ?>
        </div>

        <div class="mySlides">
          <div class="numbertext">3 / 6</div>
          <?php echo Html::img(Yii::getAlias('@web/uploads/3.jpg'), ['width'=>'100%','height' => '300px']); ?>
        </div>
        
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>

        <div class="caption-container">
          <p id="caption"></p>
        </div>

        <div class="row">
          <div class="column">
            <?php echo Html::img(Yii::getAlias('@web/uploads/1.jpg'), ['width'=>'100%','height' => '100px','onclick'=> 'currentSlide(1)','alt' => 'Pemilu 2017','class' => 'demo cursor']); ?>
          </div>
          <div class="column">
            <?php echo Html::img(Yii::getAlias('@web/uploads/2.jpg'), ['width'=>'100%','height' => '100px','onclick'=> 'currentSlide(2)','alt' => 'Pemilu 2018','class' => 'demo cursor']); ?>
          </div>
          <div class="column">
            <?php echo Html::img(Yii::getAlias('@web/uploads/3.jpg'), ['width'=>'100%','height' => '100px','onclick'=> 'currentSlide(3)','alt' => 'Pemilu 2019','class' => 'demo cursor']); ?>
          </div>
        </div>
      </div>
      <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/header_layout')?>
</div>
</div>

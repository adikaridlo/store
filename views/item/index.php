
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\Helpers;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div  ng-app="MyApp" ng-controller="AppCtrl" class="md-padding" id="popupContainer" ng-cloak class="item-index" id="bg-content">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?> 
  <div class="row">  
<div class="tab-scrolly">
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_item',
            'id_user',
            'item_name',
            'item_price',
            'stock',
            'satuan',
            'packaging_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        // 'options'=>['class' =>'tab-scrolly'],
    ]); ?>
</div>
            
            <?php 
            $info = "";
            foreach ($dataProvider->getModels() as $row) {
              $info = $row->info;
              ?>
                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="card h-100" id="item-img">
                    <a href="#">

                        <?php
                            echo "<img class='card-img-top' src='".Yii::getAlias('@web/template/')."img/item/3.jpg' width='300' alt='Second slide'/>";
                          ?>
                    </a>
                    <div class="card-body">
                      <h4 class="card-title">
                        <a href="#"><?php echo $row->item_name; ?></a>
                      </h4>
                      <h5><?php echo "Rp. ".Helpers::digits($row->item_price); ?></h5>

                      <p class="card-text"><?php 

                      $string = strip_tags($row->info);

                      if (strlen($string) > 500) {

                          // truncate string
                          $stringCut = substr($string, 0, 150);

                          // make sure it ends in a word so assassinate doesn't become ass...
                          $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';

                          echo $string;
                      }?></p>
                      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalShipMent">Beli</button>&nbsp; -->
                    </div>
                    <div style="margin-left: 11px;">
                      <md-button class="md-primary md-raised" ng-click="showAdvanced($event, <?= $row->id_item ?>)">
                        Detail
                      </md-button>
                    </div>
                    <div class="card-footer">
                      <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                  </div>
                </div>
                <?php }?>
          </div>
            <!-- And Popup Shipment -->
<?php Pjax::end(); ?>

</div>

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


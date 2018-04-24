<?php
use app\assets\RBACAnimate;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$context = $this->context;
$labels = $context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

RBACAnimate::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';

?>
<div class="row">
    <div class="col-md-12">                     
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title"> 
                <div class="caption"> 
                <?= Html::encode($this->title) ?> 
                </div> 
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
                    <a href="javascript:;" class="remove"> </a> 
                </div> 
            </div> 
            <div class="portlet-body"> 
                <div class="table-responsive">
                    <div class="tabbable-line boxless tabbable-reversed portlet light">
                 
                        <p>
                            <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>'.Yii::t('app', 'Back'), 
                                ['index'], 
                                [
                                    'class' => 'btn btn-info', 
                                    'title' => 'Back'
                                ]) ?>
                            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
                            <?=
                                Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->name], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ])
                            ?>
                        </p>

                        <div class="tab-content">
                            <div class="ownership-status-form">
                                <?=
                                    DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'name',
                                            'description:ntext',
                                            'ruleName',
                                            'data:ntext',
                                        ],
                                        'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>',
                                    ]);
                                ?>
                            </div>  

                            <div class="row">
                                <div class="col-md-5">
                                    <input class="form-control search" data-target="available" placeholder="<?=Yii::t('app', 'Search for available');?>">
                                    <select multiple size="20" class="form-control list" style="height:300px"  data-target="available"></select>
                                </div>

                                <div class="col-md-2 text-center" style="margin-top:35px;margin-bottom:30px">
                                    <?=Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $model->name], [
                                        'class' => 'btn btn-success btn-assign',
                                        'data-target' => 'available',
                                        'title' => Yii::t('app', 'Assign'),
                                    ]);?>
                                    <br><br>
                                    <?=Html::a('&lt;&lt;' . $animateIcon, ['remove', 'id' => $model->name], [
                                        'class' => 'btn btn-danger btn-assign',
                                        'data-target' => 'assigned',
                                        'title' => Yii::t('app', 'Remove'),
                                    ]);?>
                                </div>

                                <div class="col-md-5">
                                    <input class="form-control search" data-target="assigned" placeholder="<?=Yii::t('app', 'Search for assigned');?>">
                                    <select multiple size="20" class="form-control list" style="height:300px" data-target="assigned"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>



<?php
use app\assets\RBACAnimate;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

$userName = $model->{$usernameField};

if (!empty($fullnameField)) {
    $userName .= ' (' . ArrayHelper::getValue($model, $fullnameField) . ')';
}

$userName = Html::encode($userName);

$this->title = 'Assignment : ' . $userName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $userName;

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

                        <P>
                            
                            <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>'.Yii::t('app', 'Back'), 
                                    ['index'], 
                                    [
                                        'class' => 'btn btn-info', 
                                        'title' => 'Back'
                                    ]) ?>
                        </P>

                        <div class="tab-content">
                            <div class="assignment-index">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control search" data-target="available" placeholder="Search for available">
                                        <select multiple size="20" class="form-control list" style="height:300px" data-target="available"></select>
                                    </div>

                                    <div class="col-md-2 text-center">
                                        <?=Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => (string) $model->id], [
                                            'class' => 'btn btn-success btn-assign',
                                            'data-target' => 'available',
                                            'title' => Yii::t('app', 'Assign'),
                                        ]);?><br><br>
                                        <?=Html::a('&lt;&lt;' . $animateIcon, ['revoke', 'id' => (string) $model->id], [
                                            'class' => 'btn btn-danger btn-assign',
                                            'data-target' => 'assigned',
                                            'title' => Yii::t('app', 'Remove'),
                                        ]);?>
                                    </div>

                                    <div class="col-md-5">
                                        <input class="form-control search" data-target="assigned" placeholder="Search for assigned">
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
</div>



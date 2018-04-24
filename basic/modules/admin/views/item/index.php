<?php

use app\components\rbac\RouteRule;
use app\components\rbac\Configs;
use yii\helpers\Html;
use yii\grid\GridView;

// $this->title = 'Permission';
$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('app', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
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
                            <?= Html::a(Yii::t('app', 'Create '.$labels['Item']), ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                        <div class="tab-content">
                            <div class="ownership-status-form">
                                <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'attribute' => 'name',
                                                'label' => Yii::t('app', 'Name'),
                                            ],
                                            // [
                                            //     'attribute' => 'ruleName',
                                            //     'label' => Yii::t('app', 'Rule Name'),
                                            //     'filter' => $rules
                                            // ],
                                            [
                                                'attribute' => 'description',
                                                'label' => Yii::t('app', 'Description'),
                                            ],
                                            // ['class' => 'yii\grid\ActionColumn',],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{view} {update} {delete}',
                                                'header'=>'Actions',
                                                'headerOptions'=>['style'=> 'width: 15%;text-align:center;color: #337ab7'],
                                                'contentOptions'=>['style'=>'width: 15%;text-align:center;'],
                                                'buttons' => [
                                                    'view' => function ($url) {
                                                        return Html::a(
                                                            '<button type="button" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></button>',
                                                            $url,
                                                            [
                                                                'title' => 'View',
                                                                // 'data-pjax' => '0',
                                                                // 'data' => [
                                                                //     'method' => 'post',
                                                                // ]
                                                            ]
                                                        );
                                                    },

                                                    'update' => function ($url) {
                                                        return Html::a(
                                                            '<button type="button" class="btn btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>',
                                                            $url,
                                                            [
                                                                'title' => 'Update',
                                                                'data-pjax' => '0',
                                                                'data' => [
                                                                    'method' => 'post',
                                                                ]
                                                            ]
                                                        );
                                                    },

                                                    'delete' => function ($url, $model) {
                                                        return Html::a(
                                                            '<button type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></button>',
                                                            $url,
                                                            [
                                                                'title' => 'Delete',
                                                                'data-pjax' => '0',
                                                                'data'=>[
                                                                   'method' => 'post',
                                                                   'confirm' => 'Are you sure?',
                                                               ],
                                                            ]
                                                        );
                                                    },
                                                ]
                                            ],
                                        ],
                                    ])
                                ?>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>


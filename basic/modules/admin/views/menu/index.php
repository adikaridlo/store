<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
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
                            <?= Html::a(Yii::t('app', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a(Yii::t('app', 'Easy Menu Order'), ['/admin-override/menu-easy-order'], ['class' => 'btn btn-info']) ?>
                        </p>
                        <div class="tab-content">
                            <div class="ownership-status-form">
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'name',
                                        // [
                                        //     'attribute' => 'menuParent.name',
                                        //     'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                                        //         'class' => 'form-control', 'id' => null
                                        //     ]),
                                        //     'label' => Yii::t('app', 'Parent'),
                                        // ],
                                        [
                                            'label' => 'Parent',
                                            'attribute' => 'menuParent.name',
                                            'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                                                'class' => 'form-control', 'id' => null
                                            ]),
                                            'value' => function($model){
                                                if (empty($model->parent)) {
                                                    return 'is Parent';
                                                } else return $model->menuParent->name;
                                            }
                                        ],
                                        'route',
                                        // 'order',
                                        [
                                            'label' => 'Order',
                                            'attribute' => 'order',
                                            'headerOptions' => ['style' => 'width: 7%;'],
                                            'contentOptions' => ['style' => 'text-align:center']
                                        ],
                                        [
                                            'label' => 'Icon',
                                            'value' => function($model){
                                                $model = json_decode($model->data, true);
                                                return '<i class="'.$model['icon'].'">';
                                            },
                                            'format' => 'raw',
                                            'headerOptions' => ['style' => 'color: #337ab7'],
                                            'contentOptions' => ['style' => 'text-align:center']
                                        ],
                                        // ['class' => 'yii\grid\ActionColumn'],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{update} {delete}',
                                            'header'=>'Actions',
                                            'headerOptions'=>['style'=> 'width: 10%;text-align:center;color: #337ab7'],
                                            'contentOptions'=>['style'=>'width: 10%;text-align:center;'],
                                            'buttons' => [
                                                'update' => function ($url) {
                                                    return Html::a(
                                                        '<button type="button" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-pencil"></i></button>',
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
                                                               'params'=>['id' => $model->id],
                                                           ],
                                                        ]
                                                    );
                                                },
                                            ]
                                        ],
                                    ],
                                ]);
                                ?>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>


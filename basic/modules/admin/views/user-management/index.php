<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Management';
$this->params['breadcrumbs'][] = $this->title;
?>

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

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Admin', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                // 'user_type',
                'email:email',
                //'login_failed',
                //'last_login_attempt',
                //'penalty_time',
                //'created_date',
                //'updated_date',
                //'auth_key',
                // 'phone_number',
                [
                    'label' => 'Status',
                    'attribute' => 'is_active',
                    // 'filter' => \kartik\select2\Select2::widget([
                    //     'model' => $searchModel,
                    //     'attribute' => 'is_active',
                    //     'data' => [0 => 'Inactive', 1 => 'Active'],
                    //     'options' => [
                    //         'placeholder' => 'All',
                    //     ],
                    //     'pluginOptions' => [
                    //         'allowClear' => true
                    //     ],
                    // ]),
                    'filter' => [0 => 'Inactive', 1 => 'Active'],
                    'value' => function($model){
                        if ($model->is_active == 0) {
                            $isActive = 'Inactive';
                        } else
                            $isActive = 'Active';

                        return $isActive;
                    },
                    'filterInputOptions' => [
                        'class'  => 'form-control text-center',
                        'prompt' => 'All'
                    ],
                    'headerOptions' => ['width' => '8%'],
                    'contentOptions' =>function ($model, $key, $index, $column){

                        if ($model->is_active == 0) {
                            $isActive = ['style' => 'text-align: center; color:red;'];
                        } else {
                            $isActive = ['style' => 'text-align: center; color:green; font-style:italic;'];
                        }

                        return $isActive;
                    },

                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Action',
                    'headerOptions' => ['style' => 'color: #337ab7;text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'template' => '{activate}',
                    'buttons' => [
                        'activate' => function ($url, $model) {
                            if ($model->is_active == 1) {
                                return Html::a(
                                    '<button type="button" class="btn btn-danger btn-xs">Inactive</button>',
                                    $url,
                                    [
                                        'title' => 'Inactive',
                                        'data-pjax' => '0',
                                        'data' => [
                                            'confirm' => 'Are you sure to deactivate this User?',
                                            'method' => 'post',
                                        ]
                                    ]
                                );
                            } else {
                                return Html::a(
                                    '<button type="button" class="btn btn-success btn-xs">
                                        <span>Activate</span>
                                    </button>',
                                    $url,
                                    [
                                        'title' => 'Activate',
                                        'data-pjax' => '0',
                                        'data' => [
                                            'confirm' => 'Are you sure to activate this User?',
                                            'method' => 'post',
                                        ]
                                    ]
                                );
                            }
                        },
                    ],
                    'visible' => Yii::$app->user->can('super_admin')
                ],
                // 'merchant_id',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'contentOptions' => ['style' => 'text-align: center;'],

                    // 'header'=>'Actions',
                    'buttons' => [
                        'update' => function ($url,$data) {
                            $url = '/admin/user-management/update?id='.$data->user_id;
                            return Html::a(
                                '<button type="button" class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></button>',
                                $url,
                                [
                                    // 'data-pjax' => '0',
                                    'title' => 'Update',
                                    'data' => [
                                        // 'method' => 'post',
                                    ]
                                ]
                            );
                        },
                    ],
                    'visible' => Yii::$app->user->can('super_admin')
                ],

            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

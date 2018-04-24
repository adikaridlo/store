<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Users;

$this->title = 'Assignment';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(Yii::getAlias('@web/theme/') . 'assets/global/plugins/select2/css/select2.min.css', ['position' => \yii\web\View:: POS_BEGIN]);
$this->registerCssFile(Yii::getAlias('@web/theme/') . 'assets/global/plugins/select2/css/select2-bootstrap.min.css', ['position' => \yii\web\View:: POS_BEGIN]);

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    // $usernameField,
    [
        'label' => 'Name',
        'attribute' => 'name',
        'filter'=> Html::activeDropDownList($searchModel, 'name', array('' => 'All') + Users::findAvailable('name'),
            [
                // 'style'=>'width:120px;padding-left:40px;margin-left:20px;',
            'class' => 'form-control select2 select2-accessible',
            'data-plugin'=>'select2',
        ]),
        'filterInputOptions' => [
            'class'  => 'form-control',
            'prompt' => 'All'
        ],
        'headerOptions'=>['style'=>'text-align:center;width:50%'],
        // 'contentOptions'=>['style'=>'text-align:center;width:20%'],
    ],
    [
        'label' => 'User Type',
        'attribute' => 'user_type',
        'filter'=> array('super_admin' => 'Super Admin', 'admin' => 'Admin', 'aggregator' => 'Aggregator', 'merchant' => 'Merchant', 'sub_merchant' => 'Sub Merchant'),
        'filterInputOptions' => [
            'class'  => 'form-control text-center',
            'prompt' => 'All'
        ],
    ]
];

if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}

$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'headerOptions' => ['class' => 'text-center text-uppercase'],
    'header' => '#',
    'template' => '{view}',
    'buttons' => [
       'view' => function ($url) {
            return Html::a(
                '<button type="button" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></button>',
                $url,
                [
                    'title' => 'View',
                    'data-pjax' => '0',
                    'data' => [
                        'method' => 'post',
                    ]
                ]
            );
        },
    ],
    'contentOptions' => [
        'style' => 'width:52px',
    ],
];

$pager = [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ];

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
                 
                        <!-- <div class="tab-content"> -->
                            <div class="assignment-index">

                                <?php Pjax::begin(['enablePushState' => true]);
                                $this->registerJs("$('#userssearch-name').select2({
                                        allowClear: false,
                                        width: '100%'
                                    });", \yii\web\View::POS_END); 
                                ?>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => $columns,
                                    'pager' => $pager
                                ]);
                                ?>
                                <?php Pjax::end(); ?>

                            </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php
$this->registerJsFile(Yii::getAlias('@web/theme/') . 'assets/layouts/layout/scripts/layout.min.js',['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile(Yii::getAlias('@web/theme/') . 'assets/global/plugins/select2/js/select2.full.min.js',['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile(Yii::getAlias('@web/theme/') . 'assets/pages/scripts/components-select2.min.js',['depends'=>['app\assets\AppAsset']]);
?>

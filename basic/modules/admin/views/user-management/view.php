<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'View';
$this->params['breadcrumbs'][] = ['label' => 'Admin Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">                     
        <div class="portlet light bordered">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable-line boxless tabbable-reversed portlet light bordered">
                            <div class="users-view">

                                <!-- <p>
                                    <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </p> -->
                                <p>
                                    <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Cancel',
                                    ['index'],
                                    [
                                        'class' => 'btn btn-labeled btn-info m-b-5 pull-left',
                                        'title' => 'Cancel'
                                    ]) ?>&nbsp;
                                    <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
                                    <?php
                                    if ($model->is_active == 1) {
                                        echo Html::a('Inactive', ['activate', 'id' => $model->user_id], ['class' => 'btn btn-danger']);
                                    } else if ($model->is_active == 0) {
                                        echo Html::a('Activate', ['activate', 'id' => $model->user_id], ['class' => 'btn btn-success']);
                                    }
                                    ?>
                                </p>

                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'name',
                                        'user_type',
                                        'email:email',
                                        'created_date',
                                        'phone_number',
                                        'merchant_id',
                                    ],
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>



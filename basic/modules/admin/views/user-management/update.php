<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Admin Management', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
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
                            <div class="users-update">
							    <?= $this->render('_form', [
							        'model' => $model,
							    ]) ?>
							</div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>


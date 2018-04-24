<?php
/*
use app\assets\RBACAutocomplete;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use app\models\rbac\Menu;

// RBACAutocomplete::register($this);
$opts = Json::htmlEncode([
        'menus' => Menu::getMenuSource(),
        'routes' => Menu::getSavedRoutes(),
    ]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

            <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name']) ?>

            <?= $form->field($model, 'route')->textInput(['id' => 'route']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'order')->input('number') ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord
                    ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

*/?>


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\rbac\Menu;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
// use mdm\admin\AutocompleteAsset;

$this->registerCssFile(Yii::getAlias('@web/theme/') . 'assets/global/plugins/select2/css/select2.min.css', ['position' => \yii\web\View:: POS_BEGIN]);
$this->registerCssFile(Yii::getAlias('@web/theme/') . 'assets/global/plugins/select2/css/select2-bootstrap.min.css', ['position' => \yii\web\View:: POS_BEGIN]);
// AutocompleteAsset::register($this);
$icons = Yii::$app->params['icons'];
$bmenus = Menu::getMenuSource();
foreach ($bmenus as $bm) {
    if (empty($bm['parent_name'])) {
        $menus[$bm['name']] = $bm['name'];
    }
}
ArrayHelper::removeValue($menus, $model->name);
$broutes = Menu::getSavedRoutes();
foreach ($broutes as $key => $value) {
    $routes[$value] = $value;
}
$this->registerJsFile('@web/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile("@web/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>

<div class="menu-form">
    <?php
        $form = ActiveForm::begin(['action' =>['/admin-override/menu?id='.$model->id]]);
        $model->data = json_decode($model->data, true);
    ?>
    <!-- <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?> -->
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

            <?= $form->field($model, 'parent_name')->dropDownList($menus, ['prompt'=>'', 'class' => 'form-control select2me']) ?>

            <?= $form->field($model, 'route')->dropDownList($routes, ['class' => 'form-control select2me']) ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'data[icon]')->dropDownList($icons, ['prompt'=>'Pilih Icon', 'class' => 'form-control select2me'])->label('Icon') ?>

            <?php //echo $form->field($model, 'data[hide]', ['template' => "{label}\n<br>{input}"])->checkbox(['label'=>'', 'class' => 'make-switch', 'data-animate'=>"false", 'value'=>1, 'data-on-text'=>"True", 'data-off-text'=>"False"])->label('Hide') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Cancel', 
            ['/admin/menu/index'], 
            [
                'class' => 'btn btn-labeled btn-info m-b-5 pull-left', 
                'title' => 'Cancel'
            ]) ?>&nbsp;
        <?=
        Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJsFile(Yii::getAlias('@web/theme/') . 'assets/global/plugins/select2/js/select2.min.js', ['depends'=>[\yii\web\JqueryAsset::className()] ]);

$js = <<<JS

$(document).ready(function() {

    function formatTemplate(icon) {
        if (!icon.id) {
            return icon.text;
        }
        var state = $(
            "<span><i class='" + icon.element.value.toLowerCase() + "' /> " + icon.text + "</span>"
        );
        return state;
    }

    $('#menu-data-icon').select2({
        // allowClear: true,
        // formatResult: formatResult,
        // formatSelection: formatli,
        width:"60%",
        templateResult: formatTemplate,
        templateSelection: formatTemplate,
        // escapeMarkup: function (m) {
        //     // console.log(m);
        //     // return "&nbsp;&nbsp;<i style='padding-left:13px;' class='" + m + "'/>" + m;
        //     return m;            
        // }
    });

    });
JS;

$this->registerJs($js);

?>


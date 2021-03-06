<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Country;

/* @var $this yii\web\View */
/* @var $model backend\models\Region */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'country_code')->textInput(['maxlength' => true]) ?>

    <?php $code=Country::find()->all();
    $listData=ArrayHelper::map($code, 'id', 'code');
    echo $form->field($model, 'country_code')->dropDownList(
        $listData,
        ['prompt'=>'Country Code'])->label('Select Country Code');

    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'status')->textInput() ?>
    <?php echo $form->field($model, 'status')->dropDownList(['1' => 'Activate', '0' => 'Deactivate']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryImages */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-images-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'category_id',

            [                      // the owner name of the model
            'label' => 'Category',
            $category = \backend\models\Category::find()->where(['id'=>$model->category_id])->one(),
            'value' => $category->title,
            ],
            
            //'image',
            [
                'label' => 'Category Image',
                'attribute'=>'image',
                'value'=> Yii::$app->request->BaseUrl.'/uploads/'.$model->image,
                'format' => ['image',['width'=>'180']],
            ],
        ],
    ]) ?>

</div>
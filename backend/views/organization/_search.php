<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrganizationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organization-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'end_date') ?>

    <?= $form->field($model, 'organization_name') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'sk_number') ?>

    <?php // echo $form->field($model, 'ministry_address') ?>

    <?php // echo $form->field($model, 'ministry_address1') ?>

    <?php // echo $form->field($model, 'ministry_address2') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

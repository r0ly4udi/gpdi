<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Parameter;
use kartik\widgets\DatePicker;
use kartik\widgets\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\m1\models\Pastor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pastor-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'pastor-form-vertical',
        'type' => ActiveForm::TYPE_HORIZONTAL
    ]);
    ?>

    <?= $form->field($model, 'front_title')->textInput(['maxlength' => true]) ?>
    <? /*= $form->field($model, 'front_title')->widget(\kartik\widgets\Select2::classname(), [
            'name' => 'front_title',
            'value' => ['Pdt.'],
            'options' => ['placeholder' => 'Input Front Title ...', 'multiple' => true],
            'data' => ['Pdt.'=>'Pdt.','Pdm.'=>'Pdm.','Pdp.'=>'Pdp.'],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ]]
    );*/
    ?>

    <?= $form->field($model, 'pastor_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'back_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_date')->widget(DatePicker::classname(), [
            'name' => 'birth_date',
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            //'value' => '23-Feb-1982',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
                'startDate' => "01-01-1900",
                'endDate' => "01-01-2000",
                'startView' => 2
            ],
        ]
    );
    ?>

    <?= $form->field($model, 'gender_id')->dropDownList(
        ArrayHelper::map(Parameter::find()->where('group_name = "gender"')->all(), 'id', 'description')); ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'address1')->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Search desa/kelurahan and kecamatan...'],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
            [
                //'prefetch' => Url::to(['pastor/ackabupatenkota']),
                'remote' => [
                    'url' => Url::to(['pastor/acdesakelkecamatan']) . '?key=%QUERY',
                    //'url' => Url::to(['pastor/ackabupatenkota','key'=>'%QUERY']),
                    'wildcard' => '%QUERY'
                ]
            ]
        ]
    ]);
    ?>

    <?= $form->field($model, 'address2')->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Search kabupaten or kota ...'],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
            [
                'remote' => [
                    'url' => Url::to(['pastor/ackabupatenkota']) . '?key=%QUERY',
                    'wildcard' => '%QUERY'
                ]
            ]
        ]
    ]);
    ?>

    <?= $form->field($model, 'address3')->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Search province ...'],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
            [
                'remote' => [
                    'url' => Url::to(['pastor/acprovince']) . '?key=%QUERY',
                    'wildcard' => '%QUERY'
                ]
            ]
        ]
    ]);
    ?>

    <?= $form->field($model, 'handphone', [
        'feedbackIcon' => [
            'default' => 'phone',
            'success' => 'check-circle',
            'error' => 'exclamation-sign',
        ]
    ])->textInput(['placeholder' => 'Input phone number']) ?>

    <?= $form->field($model, 'email',
        ['addon' => ['prepend' => ['content' => '@']]])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
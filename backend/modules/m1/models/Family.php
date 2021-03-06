<?php

namespace backend\modules\m1\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use common\components\IndoDateTimeBehavior;
use backend\models\Parameter;


/**
 * This is the model class for table "family".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $relation_id
 * @property string $family_name
 * @property string $birth_place
 * @property string $birth_date
 * @property integer $gender_id
 * @property string $handphone
 * @property string $email
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 */
class Family extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'family';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'family_name', 'birth_place', 'birth_date'], 'required'],
            [['parent_id', 'relation_id', 'gender_id', 'created_at', 'updated_at', 'status_id'], 'integer'],
            [
                'birth_date',
                'date',
                'format' => 'php:d-m-Y',
            ],
            [['remark'], 'string'],
            [['email'], 'email'],
            [['family_name', 'birth_place', 'handphone', 'email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'relation_id' => 'Hub. Keluarga',
            'familyRelation.description' => 'Hub. Keluarga',
            'family_name' => 'Anggota Kel',
            'birth_place' => 'Tempat Lahir',
            'birth_date' => 'Tgl. Lahir',
            'gender_id' => 'J. Kelamin',
            'gender.description' => 'J. Kelamin',
            'handphone' => 'Handphone',
            'email' => 'Email',
            'status_id' => 'Status',
            'status.name' => 'Status',
            'remark' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getFamilyRelation()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'relation_id'])->andWhere(['group_name' => "family"]);
    }

    public function getGender()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'gender_id'])->andWhere(['group_name' => "gender"]);
    }

    public function getStatus()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'status_id'])->andWhere(['group_name' => "statusfamily"]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                //'createdAtAttribute' => 'create_time',
                //'updatedAtAttribute' => 'update_time',
                //'value' => new Expression('NOW()'),
            ],
            'dateTimeBehavior' => [
                'class' => IndoDateTimeBehavior::className(),
            ]
        ];

    }

}

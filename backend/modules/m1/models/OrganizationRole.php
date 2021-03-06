<?php

namespace backend\modules\m1\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\components\IndoDateTimeBehavior;
use backend\models\Organization;
use backend\models\Parameter;

/**
 * This is the model class for table "organization_role".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $organization_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $role_id
 * @property string $title
 * @property integer $report_to_id
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class OrganizationRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'organization_id', 'start_date', 'title'], 'required'],
            [
                ['parent_id', 'organization_id', 'role_id', 'report_to_id', 'status_id', 'created_at', 'updated_at'],
                'integer'
            ],
            [['start_date', 'end_date'], 'date', 'format' => 'php:d-m-Y'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent',
            'organization_id' => 'Organisasi',
            'organization.organization_name' => 'Organisasi',
            'start_date' => 'Tgl. Mulai',
            'end_date' => 'Tgl. Selesai',
            'role_id' => 'Jabatan',
            'role.description' => 'Jabatan',
            'title' => 'Nama Jabatan',
            'report_to_id' => 'Atasan',
            'reportTo.pastor_name' => 'Atasan',
            'status_id' => 'Status',
            'status.description' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'status_id'])->andWhere(['group_name' => "status"]);
    }

    public function getReportTo()
    {
        return $this->hasOne(Pastor::className(), ['id' => 'report_to_id']);
    }

    public function getRole()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'role_id'])->andWhere(['group_name' => "jabatanorg"]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            'dateTimeBehavior' => [
                'class' => IndoDateTimeBehavior::className(),
            ]
        ];

    }

}

<?php

namespace backend\modules\m1\models;

use Yii;
use common\components\IndoDateTimeBehavior;
use kartik\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use backend\models\Parameter;


/**
 * This is the model class for table "pastor".
 *
 * @property integer $id
 * @property string $pastor_name
 * @property string $front_title
 * @property string $back_title
 * @property string $birth_place
 * @property string $birth_date
 * @property integer $gender_id
 * @property string $address
 * @property string $address1
 * @property string $address2
 * @property string $handphone
 * @property string $email
 * @property string $remark
 * @property string $photo_path
 * @property integer $created_at
 * @property integer $updated_at
 */
class Pastor extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $organization_parent_id; //default ministry
    public $start_date;             //default ministry
    public $church_name;            //default ministry

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pastor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pastor_name', 'birth_place', 'birth_date', 'address', 'handphone'], 'required'],
            [['organization_parent_id', 'start_date', 'church_name'], 'required', 'on' => 'newpastor'],

            //['birth_date','validateUserBirthDate'],
            [
                'birth_date',
                'date',
                'format' => 'php:d-m-Y',
                'max' => date('d-m-Y', strtotime('-15 years')),
                'min' => date('d-m-Y', strtotime('-90 years')),
                'tooSmall' => 'Your birth date input seem invalid due it is more than 90 years',
                'tooBig' => 'Your birth date input seem invalid due it is less than 15 years',
            ],
            ['start_date', 'date', 'format' => 'php:d-m-Y'],

            [['gender_id', 'created_at', 'updated_at', 'organization_parent_id'], 'integer'],
            [['remark'], 'string'],
            [['email'], 'email'],

            [
                'handphone',
                'match',
                'pattern' => '/08\d{8,10}/',
                'message' => 'Handphone number must be at least 10 digit, 
            no space, no "-",  and started with 08xxxxxx '
            ],

            [['pastor_name', 'birth_place', 'email', 'home_phone'], 'string', 'max' => 100],
            [['front_title', 'back_title', 'pos_code'], 'string', 'max' => 25],
            [['address', 'address1', 'address2', 'address3', 'photo_path', 'church_name'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function validateUserBirthDate($attribute, $params)
    {
        $minAgeDate = strtotime('-10 years');
        $maxAgeDate = strtotime('-100 years');
        if (strtotime($this->$attribute) > $minAgeDate) {
            $this->addError($attribute, 'Date is too small.');
        } elseif (strtotime($this->$attribute) < $maxAgeDate) {
            $this->addError($attribute, 'Date is to big.');
        }
        $this->addError($attribute, 'Date is to big.');
    }

    public function upload()
    {
        if ($this->validate() && $this->imageFile != null) {
            $this->imageFile->saveAs('images/pastor/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pastor_name' => 'Nama Gembala',
            'front_title' => 'Gelar Depan',
            'back_title' => 'Gelar Blkg',
            'birth_place' => 'Tempat Lahir',
            'birth_date' => 'Tgl. Lahir',
            'gender_id' => 'J. Kelamin',
            'gender.description' => 'J. Kelamin',
            'address' => 'Alamat',
            'address1' => 'Desa/Kelurahan',
            'address2' => 'Kab/Kodya',
            'address3' => 'Propinsi',
            'handphone' => 'Handphone',
            'home_phone' => 'Tel. Rumah',
            'email' => 'Email',
            'remark' => 'Keterangan',
            'user_id' => 'User',
            'photo_path' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ministry.ministryParent.name' => 'Wilayah',
            'organization_parent_id' => 'Organization Parent',
            'start_date' => 'Tgl. Mulai',
            'church_name' => 'Nama Gereja',
        ];
    }

    public function getGender()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'gender_id'])->andWhere(['group_name' => "gender"]);
    }

    public function getMinistry()
    {
        return $this->hasOne(Ministry::className(), ['parent_id' => 'id'])->orderBy('start_date DESC')->limit(1);
    }

    public function getMinistryMany()
    {
        return $this->hasMany(Ministry::className(), ['parent_id' => 'id'])->orderBy('start_date DESC');
    }

    public function getPhotoPath()
    {
        $options = ['width' => '100%', 'id' => 'photo', 'align' => 'left', 'class' => 'class-image'];
        if ($this->photo_path != null && $this->getPhotoExist()) {
            if ($this->getPhotoExistThumb()) {
                $path = Html::img('@web/images/thumb/' . $this->photo_path, $options);
            } else {
                $path = Html::img('@web/images/' . $this->photo_path, $options);
            }
        } else {
            if ($this->gender_id == 1) {
                $path = Html::img('@web/images/nophoto.jpg', $options);
            } else {
                $path = Html::img('@web/images/nophotoW.jpg', $options);
            }
        }

        return $path;
    }

    public function getPhotoExist()
    {
        if ($this->photo_path != null) {
            return is_file(Yii::getAlias('@app') . '/web/images/' . $this->photo_path) ? true : false;
        } else {
            return false;
        }
    }

    public function getPhotoExistThumb()
    {
        if ($this->photo_path != null) {
            return is_file(Yii::getAlias('@web') . '/web/images/thumb/' . $this->photo_path) ? true : false;
        } else {
            return false;
        }
    }

    public function getPhotoPathReal()
    {
        if ($this->photo_path != null && $this->getPhotoExist()) {
            if ($this->getPhotoExistThumb()) {
                $path = '@web/images/thumb/' . $this->photo_path;
            } else {
                $path = '@web/images/' . $this->photo_path;
            }
        } else {
            if ($this->gender_id == 1) {
                $path = '@web/images/nophoto.jpg';
            } else {
                $path = '@web/images/nophotoW.jpg';
            }
        }

        return $path;
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

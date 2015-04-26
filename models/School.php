<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property integer $id
 * @property string $name
 * @property string $fullname
 * @property integer $location_id
 * @property string $address
 * @property integer $financing
 * @property string $phone
 * @property string $phone_director
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property integer $change
 *
 * @property Location $location
 * @property TypeToSchool[] $typeToSchools
 
 * @property SchoolType[] $schoolTypes
 */
class School extends \yii\db\ActiveRecord
{
    const CHANGE_TYPE_ONE = 1;
    const CHANGE_TYPE_TWO = 2;
    
    const FINANCING_STATE = 1;
    const FINANCING_PRIVATE = 2;
    const FINANCING_MUNICIPAL = 3;
    const FINANCING_FOREIGN = 4;
    
    public $types;
    
    public static $change_type = [
        self::CHANGE_TYPE_ONE => 'Една смяна',
        self::CHANGE_TYPE_TWO => 'Две смени',
    ];
    
    public static $financing_type = [
        self::FINANCING_STATE => 'Държавно',
        self::FINANCING_PRIVATE => 'Частно',
        self::FINANCING_MUNICIPAL => 'Общинско',
        self::FINANCING_FOREIGN => 'Чуждестранно',
    ];
    
    public function getChangeType()
    {
        return self::$change_type[$this->change];
    }
 
    public function getFinancingType()
    {
        return self::$financing_type[$this->financing];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'fullname', 'location_id', 'address', 'financing', 'phone', 'phone_director', 'fax', 'email', 'website', 'change', 'types'], 'required'],
            [['location_id', 'financing', 'change'], 'integer'],
            [['types'], 'safe'],
            ['email', 'email'],
            ['website', 'url'],
            [['name', 'fullname', 'address', 'email', 'website'], 'string', 'max' => 255],
            [['phone', 'phone_director', 'fax'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Име',
            'fullname' => 'Пълно наименование',
            'location_id' => 'Нас. място',
            'address' => 'Адрес',
            'financing' => 'Финансиране',
            'phone' => 'Телефон',
            'phone_director' => 'Тел. директор',
            'fax' => 'Fax',
            'email' => 'Email',
            'website' => 'Уебсайт',
            'change' => 'Смяна',
            'types' => 'Вид',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeToSchools()
    {
        return $this->hasMany(TypeToSchool::className(), ['school_id' => 'id']);
    }

    //relation to school_type table through junction table type_to_school
    public function getSchoolTypes()
    {
         return $this->hasMany(SchoolType::className(), ['id' => 'type_id'])
            ->viaTable('type_to_school', ['school_id' => 'id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            TypeToSchool::deleteAll('school_id = :school', [':school' => $this->id]);
            return true;
        } else {
            return false;
        }
    }
}

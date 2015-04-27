<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_to_school".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $school_id
 *
 * @property School $school
 * @property SchoolType $type
 */
class TypeToSchool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_to_school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'school_id'], 'required'],
            [['type_id', 'school_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'school_id' => 'School ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(SchoolType::className(), ['id' => 'type_id']);
    }
}

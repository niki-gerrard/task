<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TypeToSchool[] $typeToSchools
 */
class SchoolType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            ['type', 'unique', 'on'=>'create'],
            [['type'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Вид',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeToSchools()
    {
        return $this->hasMany(TypeToSchool::className(), ['type_id' => 'id']);
    }
}

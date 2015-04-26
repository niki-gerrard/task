<?php

namespace app\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\School;

/**
 * SchoolSearch represents the model behind the search form about `app\models\School`.
 */
class SchoolSearch extends School
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'location_id', 'financing', 'change'], 'integer'],
            [['name', 'fullname', 'address', 'phone', 'phone_director', 'fax', 'email', 'website', 'types'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = School::find();
        $query->distinct();
        $query->joinWith(['typeToSchools']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'school.id' => $this->id,
            'location_id' => $this->location_id,
            'financing' => $this->financing,
            'change' => $this->change,
            'type_to_school.type_id' => $this->types,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}

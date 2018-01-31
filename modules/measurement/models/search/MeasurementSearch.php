<?php

namespace measurement\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use measurement\models\Measurement;

/**
 * MeasurementSearch represents the model behind the search form about `measurement\models\Measurement`.
 */
class MeasurementSearch extends Measurement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [['name', 'short_name'], 'safe'],
            [['coefficient'], 'number'],
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
        $query = Measurement::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'coefficient' => $this->coefficient,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'short_name', $this->short_name]);

        return $dataProvider;
    }
}

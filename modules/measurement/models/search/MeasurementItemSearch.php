<?php

namespace measurement\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use measurement\models\MeasurementItem;

/**
 * MeasurementItemSearch represents the model behind the search form about `measurement\models\MeasurementItem`.
 */
class MeasurementItemSearch extends MeasurementItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'master_unit'], 'integer'],
            [['name'], 'safe'],
            [['factor'], 'number'],
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
        $query = MeasurementItem::find();

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
            'item_id' => $this->item_id,
            'master_unit' => $this->master_unit,
            'factor' => $this->factor,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

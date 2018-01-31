<?php

namespace po\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use po\models\PurchaseOrder;

/**
 * PurchaseOrderSearch represents the model behind the search form about `po\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'user_id', 'supplier_id', 'location_id', 'shipping_address_id'], 'integer'],
            [['requested_delivery_date', 'create_time', 'update_time', 'estimated_delivery_date'], 'safe'],
            [['food_cost_est', 'food_cost_act', 'total_cost_act', 'total_cost_est', 'shipping_cost_act', 'shipping_cost_est', 'total_price', 'sales_tax', 'total_weight', 'total_volume'], 'number'],
            [['shipping_configuration'], 'string'],
            [['requested_delivery_time'], 'string', 'max' => 12],
            [['special_instructions'], 'string', 'max' => 511],
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
        $query = PurchaseOrder::find();

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
            // ToDO: add more later
            /*'coefficient' => $this->coefficient,
            'type' => $this->type,*/
        ]);

        // ToDo: perfect this later on!
        $query->andFilterWhere(['like', 'shipping_configuration', $this->shipping_configuration])
            ->andFilterWhere(['like', 'special_instructions', $this->special_instructions]);

        return $dataProvider;
    }
}

<?php

namespace inventory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use inventory\models\InventoryLocationManualCount;

/**
 * InventoryLocationManualCountSearch represents the model behind the search form about `inventory\models\InventoryLocationManualCount`.
 */
class InventoryLocationManualCountSearch extends InventoryLocationManualCount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'location_id', 'active', 'user_id'], 'integer'],
            [['create_time', 'end_time'], 'safe'],
            [['on_hand_quantity'], 'number'],
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
        $query = InventoryLocationManualCount::find();

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
            'location_id' => $this->location_id,
            'create_time' => $this->create_time,
            'on_hand_quantity' => $this->on_hand_quantity,
            'active' => $this->active,
            'user_id' => $this->user_id,
            'end_time' => $this->end_time,
        ]);


        if(isset($_GET['create_timeFrom']) && $_GET['create_timeFrom'])
			$query->andWhere("create_time>=STR_TO_DATE('{$_GET['create_timeFrom']}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET['create_timeTo']) && $_GET['create_timeTo'])
			$query->andWhere("create_time<=STR_TO_DATE('{$_GET['create_timeTo']}', '%Y-%m-%d %H:%i:%s')");

        if(isset($_GET['end_timeFrom']) && $_GET['end_timeFrom'])
			$query->andWhere("end_time>=STR_TO_DATE('{$_GET['end_timeFrom']}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET['end_timeTo']) && $_GET['end_timeTo'])
			$query->andWhere("end_time<=STR_TO_DATE('{$_GET['end_timeTo']}', '%Y-%m-%d %H:%i:%s')");


        return $dataProvider;
    }
}

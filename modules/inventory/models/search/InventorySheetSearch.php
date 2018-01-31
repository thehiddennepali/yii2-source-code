<?php

namespace inventory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use inventory\models\InventorySheet;

/**
 * InventorySheetSearch represents the model behind the search form about `inventory\models\InventorySheet`.
 */
class InventorySheetSearch extends InventorySheet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'location_id', 'sub_location_id', 'category_id'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
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
        $query = InventorySheet::find();

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'location_id' => $this->location_id,
            'sub_location_id' => $this->sub_location_id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if(isset($_GET['created_atFrom']))
			$query->andWhere("created_at>=STR_TO_DATE('{$_GET['created_atFrom']}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET['created_atTo']))
			$query->andWhere("created_at<=STR_TO_DATE('{$_GET['created_atTo']}', '%Y-%m-%d %H:%i:%s')");

        if(isset($_GET['updated_atFrom']))
			$query->andWhere("updated_at>=STR_TO_DATE('{$_GET['updated_atFrom']}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET['updated_atTo']))
			$query->andWhere("updated_at<=STR_TO_DATE('{$_GET['updated_atTo']}', '%Y-%m-%d %H:%i:%s')");

        return $dataProvider;
    }
}

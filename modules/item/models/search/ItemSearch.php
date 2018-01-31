<?php

namespace item\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use item\models\Item;

/**
 * ItemSearch represents the model behind the search form about `item\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'purchasable', 'has_ingredients', 'cube_unit', 'yield', 'assembly_people_count', 'container_type_id'], 'integer'],
            [['item_name', 'create_time', 'update_time', 'gtin', 'unit_measure', 'item_description', 'categories_json', 'ingredients_json', 'diet_labels', 'alergens', 'short_name', 'image_url', 'sku', 'orig_id', 'prep', 'bricks', 'unit_weight', 'item_type', 'labor_process'], 'safe'],
            [['inner_pack', 'outer_pack', 'size', 'size_unit','height', 'width', 'depth', 'weight', 'weight_interval', 'prod_pounds_per_man_hour', 'assembly_units_hour'], 'number'],
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
        $query = static::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'published' => $this->published,
            'purchasable' => $this->purchasable,
            'has_ingredients' => $this->has_ingredients,
            'inner_pack' => $this->inner_pack,
            'outer_pack' => $this->outer_pack,
            'size' => $this->size,
            'size_unit' => $this->size_unit,
            'height' => $this->height,
            'width' => $this->width,
            'depth' => $this->depth,
            'cube_unit' => $this->cube_unit,
            'weight' => $this->weight,
            'weight_interval' => $this->weight_interval,
            'yield' => $this->yield,
            'prod_pounds_per_man_hour' => $this->prod_pounds_per_man_hour,
            'assembly_people_count' => $this->assembly_people_count,
            'assembly_units_hour' => $this->assembly_units_hour,
            'container_type_id' => $this->container_type_id,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'gtin', $this->gtin])
            ->andFilterWhere(['like', 'unit_measure', $this->unit_measure])
            ->andFilterWhere(['like', 'item_description', $this->item_description])
            ->andFilterWhere(['like', 'categories_json', $this->categories_json])
            ->andFilterWhere(['like', 'ingredients_json', $this->ingredients_json])
            ->andFilterWhere(['like', 'diet_labels', $this->diet_labels])
            ->andFilterWhere(['like', 'alergens', $this->alergens])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'image_url', $this->image_url])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'orig_id', $this->orig_id])
            ->andFilterWhere(['like', 'prep', $this->prep])
            ->andFilterWhere(['like', 'bricks', $this->bricks])
            ->andFilterWhere(['like', 'unit_weight', $this->unit_weight])
            ->andFilterWhere(['like', 'item_type', $this->item_type])
            ->andFilterWhere(['like', 'labor_process', $this->labor_process]);

        return $dataProvider;
    }
}

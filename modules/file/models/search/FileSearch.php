<?php

namespace file\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use file\models\File;

/**
 * FileSearch represents the model behind the search form about `common\models\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'type'], 'integer'],
            [['model_name', 'file_name', 'title'], 'safe'],
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
        $query = File::find();

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
            'model_id' => $this->model_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'title', $this->title])
        ;

        return $dataProvider;
    }
}

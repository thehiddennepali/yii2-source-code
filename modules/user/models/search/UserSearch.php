<?php

namespace user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use user\models\User;
use yii\validators\DateValidator;

/**
 * UserSearch represents the model behind the search form about `user\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'referrer_id', 'from'], 'safe'],
            [['first_name', 'last_name'], 'safe'],
            ['rolesAttribute', 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->defaultFrom();
        /*$query->joinWith([
            'referrer' => function (\yii\db\ActiveQuery $query) {
                    $query->from(['referrer'=>$this->tableName(),]);
                },
        ]);*/
        $query->andFilterWhere(['OR', ['like', 'referrer.first_name', $this->referrer_id], ['like', 'referrer.last_name', $this->referrer_id]]);

        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.status' => $this->status,
            'u.created_at' => $this->created_at,
            'u.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email])
            ->andFilterWhere(['like', 'u.first_name', $this->first_name])
            ->andFilterWhere(['like', 'u.last_name', $this->last_name])
            ->andFilterWhere(['like', 'u.from', $this->from])
        ;

        $query->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email])
            ->andFilterWhere(['like', 'u.from', $this->from])
        ;
        if($this->rolesAttribute){
            $query->leftJoin('{{%auth_assignment}} assignment', 'u.id=assignment.user_id')
                ->groupBy('u.id')
                ->andWhere(['assignment.item_name'=>$this->rolesAttribute]);
        }


        //if(isset($_GET['from']) || isset($_GET['to']))
        {
            $dateValidator = new DateValidator();
            $dateValidator->format = 'yyyy-MM-dd';

            $dateTimeValidator = new DateValidator();
            $dateTimeValidator->format = 'yyyy-MM-dd HH:mm';
        }
        if(isset($_GET['from'])){
            if ($dateValidator->validate($_GET['from'], $error)){
                //$query->andWhere("STR_TO_DATE(u.created_at, '%Y-%m-%d')>='{$_GET['from']}'");
                $query->andWhere("u.created_at>='".strtotime($_GET['from'])."'");
            }
            if ($dateTimeValidator->validate($_GET['from'], $error)){
                //$query->andWhere("STR_TO_DATE(u.created_at, '%Y-%m-%d %H:%i')>='{$_GET['from']}'");
                $query->andWhere("u.created_at>='".strtotime($_GET['from'])."'");
            }
        }
        if(isset($_GET['to'])){
            if ($dateValidator->validate($_GET['to'], $error)){
                //$query->andWhere("STR_TO_DATE(u.created_at, '%Y-%m-%d')<='{$_GET['to']}'");
                $query->andWhere("u.created_at<='".(strtotime($_GET['to'])+24*3600-1)."'");
            }
            if ($dateTimeValidator->validate($_GET['to'], $error)){
                //$query->andWhere("STR_TO_DATE(u.created_at, '%Y-%m-%d %H:%i')<='{$_GET['to']}'");
                $query->andWhere("u.created_at<='".strtotime($_GET['to'])."'");
            }
        }

        return $dataProvider;
    }
}

<?php

namespace elephantsGroup\stat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use elephantsGroup\stat\models\Stat;

/**
 * NewsSearch represents the model behind the search form about `app\models\News`.
 */
class StatSearch extends Stat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['creation_time', 'module', 'controller', 'action'], 'safe'],
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
        $query = Stat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'creation_time' => $this->creation_time,
            'ip' => $this->ip,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'module', $this->module]);
        $query->andFilterWhere(['like', 'controller', $this->controller]);
        $query->andFilterWhere(['like', 'action', $this->action]);

        return $dataProvider;
    }
}

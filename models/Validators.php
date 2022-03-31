<?php

namespace app\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;

class Validators extends Model
{
    public $top;
    public $moniker;

    public function rules()
    {
        return [
            [['top', 'moniker','address', 'status','valkey',
                'rank', 'streak', 'pubkey', 'proposer', 'mischance', 'mischance_confidence',
                'start_height', 'inactive_until', 'last_present_block', 'missed_blocks_counter',
                'produced_blocks_counter'], 'integer'],
        ];
    }

    private $_filtered = false;

    public function search($params, $validators)
    {
        if ($this->load($params)) {
            $this->_filtered = true;
        }


        return new ArrayDataProvider([
            'allModels' => $this->getData($validators),
//            'pagination' => [
//                'pageSize' => 500,
//            ],
//            'sort' => [
//                'attributes' => ['top', 'moniker', 'validator_node_id','status', 'produced_blocks_counter'],
//            ],
        ]);
    }

//    private function getData($validators)
//    {
//        $data = $validators;
//
////        if ($this->_filtered) {
////            $data = array_filter($data, function ($value) {
////                $conditions = [true];
////                if (!empty($this->top)) {
////                    $conditions[] = strpos($value['top'], $this->name) !== false;
////                }
////                if (!empty($this->moniker)) {
////                    $conditions[] = strpos($value['code'], $this->moniker) !== false;
////                }
////                return array_product($conditions);
////            });
////        }
//
//        return $data;
//
//    }
}
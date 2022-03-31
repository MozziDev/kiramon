<?php

namespace app\services\site;

use yii\data\ArrayDataProvider;

class ValidatorPrepareData
{
    public function prepareDataProvider($validators)
    {
        return new ArrayDataProvider([
            'allModels' => $validators,
            'pagination' => [
                'pageSize' => 500,
            ],
            'sort' => [
                'attributes' => ['top', 'moniker', 'validator_node_id','status', 'produced_blocks_counter'],
            ],
        ]);
    }

    public function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public function getColumnsGridView()
    {
        if ($this->isMobile()){
            return $this->getMobilecolumn();
        }
        
        return $this->getStandartColumn();
    }

    private function getStandartColumn()
    {
        return [

            [
                'attribute' => 'favorite',
                'format' => 'raw',
                'label' => "F",
                'value' => function($data){
                    return ($data['favorite']) ? '<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-star-fill fromFavorites" data-address="'.$data['address'].'" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>' :

                        '<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-star toFavorites" data-address="'.$data['address'].'" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>';
                }
            ],
            [
                'attribute' => 'moniker',
                'contentOptions' => ['style' => 'font-size:14px; font-weight: bold'],
                'format' => 'raw',
                'value' => function($data)
                {
                    $status = "<span style='color: #1e7e34'>Active</span>";
                    if ($data['status'] == "PAUSED") {
                        $status = "<span style='color: #82c140'>Paused</span>";
                    }
                    if ($data['status'] == "INACTIVE") {
                        $status = "<span style='color: #FF0000'>Inactive</span>";
                    }
                    if ($data['status'] == "JAILED") {
                        $status = "<span style='color: #FF0000; text-decoration: line-through'>Jailed</span>";
                    }

                    return $data['moniker']."<br />"
                        ."Top: ".$data['top']."&nbsp;&nbsp;&nbsp;&nbsp;".$status;
                }
            ],
            [
                'attribute' => 'validator_node_id',
                'format' => 'raw',
                'value' => function($data){
                    $vnd = (array_key_exists('validator_node_id', $data)) ? $data['validator_node_id'] : "Empty";
                    return '<strong>Address:</strong> '.$data['address'].'<br />'
                        .'<strong>Node ID:</strong> '.$vnd;
                }
            ],
            //'address',
            //'status',
            //'valkey',
            //'rank',
            //'streak',
            //'pubkey',
            //'proposer',
            //'mischance',
            //'mischance_confidence',
            [
                'attribute' => 'produced_blocks_counter',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong>Produced Blocks Counter:</strong> '.$data['produced_blocks_counter'].'<br />'
                        .'<strong>Last Present Block:</strong> '.$data['last_present_block'].'<br />'
                        .'<strong>Start Height:</strong> '.$data['start_height'].'<br />'
                        .'<strong>Missed Blocks Counter:</strong> '.$data['missed_blocks_counter'];
                }
            ],
            //'start_height',
            //'inactive_until',
            //'last_present_block',
            //'missed_blocks_counter',
            //'produced_blocks_counter',
        ];
    }

    private function getMobilecolumn()
    {
        return [
            [
                'attribute' => 'moniker',
                'format' => 'raw',
                'value' => function($data){

                    $status = "<span style='color: #1e7e34'>Active</span>";
                    if ($data['status'] == "PAUSED") {
                        $status = "<span style='color: #82c140'>Paused</span>";
                    }
                    if ($data['status'] == "INACTIVE") {
                        $status = "<span style='color: #FF0000'>Inactive</span>";
                    }
                    if ($data['status'] == "JAILED") {
                        $status = "<span style='color: #FF0000; text-decoration: line-through'>Jailed</span>";
                    }
                    $vnd = (array_key_exists('validator_node_id', $data)) ? $data['validator_node_id'] : "Empty";

                    return ($data['favorite']) ? '<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-star-fill fromFavorites" data-address="'.$data['address'].'" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>'.
                        "&nbsp;&nbsp;".$data['moniker']."&nbsp;&nbsp;"
                        ."Top: ".$data['top']."&nbsp;&nbsp;&nbsp;&nbsp;".$status.'<hr />'.
                        '<strong>Address:</strong> '.$data['address'].'<br />'
                        .'<strong>Node ID:</strong> '.$vnd.'<br>'.
                        '<strong>Produced Blocks Counter:</strong> '.$data['produced_blocks_counter'].'<br />'
                        .'<strong>Last Present Block:</strong> '.$data['last_present_block'].'<br />'
                        .'<strong>Start Height:</strong> '.$data['start_height'].'<br />'
                        .'<strong>Missed Blocks Counter:</strong> '.$data['missed_blocks_counter']

                    :

                        '<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-star toFavorites" data-address="'.$data['address'].'" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>'.
                        "&nbsp;&nbsp;".$data['moniker']."&nbsp;&nbsp;"
                        ."Top: ".$data['top']."&nbsp;&nbsp;&nbsp;&nbsp;".$status.'<hr />'.
                        '<strong>Address:</strong> '.$data['address'].'<br />'
                        .'<strong>Node ID:</strong> '.$vnd.'<br>'.
                        '<strong>Produced Blocks Counter:</strong> '.$data['produced_blocks_counter'].'<br />'
                        .'<strong>Last Present Block:</strong> '.$data['last_present_block'].'<br />'
                        .'<strong>Start Height:</strong> '.$data['start_height'].'<br />'
                        .'<strong>Missed Blocks Counter:</strong> '.$data['missed_blocks_counter'];
                }
            ]
        ];
    }

}
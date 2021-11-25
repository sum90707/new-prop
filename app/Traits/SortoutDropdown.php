<?php

namespace App\Traits;


trait SortoutDropdown
{
    public static function SortoutDropdown($datas, $valueColumn, $nameColumn)
    {
        $result = array();
        foreach($datas->toArray() as $data) {
            array_push($result, [
                'value' => array_get($data, $valueColumn),
                'name' => array_get($data, $nameColumn)
            ]);
        }

        return array('values' => $result);
    }
}
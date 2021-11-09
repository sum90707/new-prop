<?php

namespace App\Traits;


trait SortoutDropdown
{
    public static function SortoutDropdown($datas, $valueColumn, $nameColumn)
    {
        $result = array();
        foreach($datas as $data) {
            array_push($result, [
                'value' => $data[$valueColumn],
                'name' => $data[$nameColumn]
            ]);
        }

        return array('values' => $result);
    }
}
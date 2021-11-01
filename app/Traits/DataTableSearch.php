<?php

namespace App\Traits;

use DataTables;

trait DataTableSearch
{


    /**
     * The function that are sort out datatable's data.
     *
     * @param model query
     * @param array request input array
     * @param array which colums will search
     * @param array which colums will hidden
     * 
     * @return array dataTable data
     */

    public static function dataTableSearch($query, $search = null, $columns = [], $hiddenColumns = [])
    {
        $query = $query->where(function ($subquery) use ($search, $columns){
            if($search['search']['value']) {
                foreach($columns as $column) {
                    $subquery->orWhere($column, 'like', '%' . $search['search']['value'] . '%');
                }
            }
        })
        ->get()
        ->makeHidden($hiddenColumns);

        return DataTables::of($query)->smart(true)->toArray();
    }
}
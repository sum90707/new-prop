<?php

namespace App\Http\Controllers;

use Auth;
use Lang;
use App\Paper;
use App\Exports\PaperExport;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function paper(Request $request, Paper $paper)
    {
        $fileName = Auth::User()->name . '-' . $paper->name . '.xlsx';

        $quesitions = $paper->quesitions->toArray();
        self::sortOptions($quesitions);
        self::translateType($quesitions);
        self::onlyColumn(
            $quesitions, 
            ['name', 'year', 'type', 'introduce', 'answer', 'option']
        );
        self::setHeader($quesitions, 'quesition');

        return Excel::download(new PaperExport($quesitions), $fileName);
    }

    private static function sortOptions(&$quesitions)
    {
        foreach($quesitions as &$quesition) {
            $options = '';
            foreach($quesition['options'] as &$option) {
                $options = $options . $option['order'] . ') ' . $option['introduce'] . '  ';
            }
            $quesition['option'] = $options;
        }
    }

    private static function translateType(&$quesitions)
    {
        $types = Lang::get('quesition.types');

        foreach($quesitions as &$quesition) {
            $quesition['type'] = $types[$quesition['type']];
        }
    }

    private static function onlyColumn(&$datas, $needs = [])
    {
        foreach($datas as &$data) {
            $data = array_only($data, $needs);
        }
    }

    private static function setHeader(&$datas, $langFile)
    {
        $header = array();
        foreach($datas[0] as $index => $data) {
            array_push($header, trans("$langFile.$index"));
        }
        array_unshift($datas, $header);
    }
    
}

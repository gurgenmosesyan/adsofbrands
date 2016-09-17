<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Subscribe\Subscribe;
use App\Models\Subscribe\SubscribeSearch;
use PHPExcel;
use PHPExcel_IOFactory;

class SubscribeController extends BaseController
{
    public function table()
    {
        return view('admin.subscribe.index');
    }

    public function index(SubscribeSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function delete($id)
    {
        Subscribe::where('id', $id)->delete();
        return $this->api('OK');
    }

    public function export()
    {
        set_time_limit(500);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(15);

        $data = Subscribe::all();
        $i = 1;
        foreach ($data as $value) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $value->email);
            $i++;
        }
        foreach (range('A', 'A') as $columnId) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $file = storage_path('app/export/subscribes.xls');
        $objWriter->save($file);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            unlink($file);
            die();
        }
        abort(404);
    }
}
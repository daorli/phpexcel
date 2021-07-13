<?php

require __DIR__ . '/cms/expand/excel/PHPExcel/Reader/Excel2007.php';

function getascii($ch)
{
    if (strlen($ch) == 1)
        return ord($ch) - 65;
    return ord($ch[1]) - 38;
}
function reader($file_temp)
{
    $PHPReader = new PHPExcel_Reader_Excel2007();
    if (!$PHPReader->canRead($file_temp)) {
        $PHPReader = new PHPExcel_Reader_Excel5();
        if (!$PHPReader->canRead($file_temp)) {
            echo 'no Excel';
        }
    }

    $PHPExcel = $PHPReader->load($file_temp);
    $currentSheet = $PHPExcel->getSheet(0);
    /**取得一共有多少列*/

    $allColumn = $currentSheet->getHighestColumn();
    /**取得一共有多少行*/

    $allRow = $currentSheet->getHighestRow();
    $all = array();
    for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
        $flag = 0;
        $col = array();
        for ($currentColumn = 'A'; getascii($currentColumn) <= getascii($allColumn); $currentColumn++) {

            $address = $currentColumn . $currentRow;
            $string = $currentSheet->getCell($address)->getValue();
            $col[$flag] = $string;
            $flag++;
        }
        $all[] = $col;
    }
    return $all;
}
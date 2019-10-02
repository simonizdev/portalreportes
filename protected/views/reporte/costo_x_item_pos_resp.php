<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="
    SELECT DISTINCT
    I_ID_ITEM as ITEM
    ,I_UNIDAD_NEGOCIO as UN
    ,f400_cant_existencia_1 as CANTIDAD
    ,f132_costo_prom_uni as COSTO
    FROM UnoEE1..t400_cm_existencia
    INNER JOIN Portal_Reportes..TH_ITEMS ON f400_rowid_item_ext = I_ROWID_ITEM
    INNER JOIN UnoEE1..t132_mc_items_instalacion ON f132_rowid_item_ext = f400_rowid_item_ext AND f132_id_instalacion='100'
    WHERE f400_rowid_bodega = 105 AND f400_cant_existencia_1!=0
";

//EXCEL

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CANTIDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'COSTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'UN');


$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ITEM            = $reg1 ['ITEM']; 
    $UN              = $reg1 ['UN']; 
    $CANTIDAD        = $reg1 ['CANTIDAD']; 
    $COSTO           = $reg1 ['COSTO'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $CANTIDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $COSTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $UN);

    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':B'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila = $Fila + 1; 
      
  }
}

/*fin contenido tabla*/

//se configura el ancho de cada columna en automatico solo funciona en el rango A-Z
foreach($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

    $sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
}

$n = 'Costo_X_Item_POS_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>

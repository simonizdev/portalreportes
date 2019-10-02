<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="
  EXEC [dbo].[CONF_CONS_ERROR_EPW]
";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Row Id');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Ept');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cantidad');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Fecha de envío');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Fecha de retorno WMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', '# Recepción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Cargado');

$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ROWID  = $reg1 ['ROWID']; 
    $EPT  = $reg1 ['EPT']; 
    $ITEM  = $reg1 ['ITEM'];
    $CANTIDAD  = number_format($reg1 ['CANTIDAD'], 0, ',', '');
    $FECHA_ENVIO  = $reg1 ['FECHA_ENVIO'];
    $FECHA_RETORNO  = $reg1 ['FECHA_RETORNO'];
    $RECEPCION  = $reg1 ['RECEPCION'];
    $CARGADO  = $reg1 ['CARGADO'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ROWID);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $EPT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $CANTIDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $FECHA_ENVIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $FECHA_RETORNO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $RECEPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $CARGADO);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0'); 
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    

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

$n = 'ept_sin_procesar_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












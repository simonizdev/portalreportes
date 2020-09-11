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
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cant. transferencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Cant. recepcionada');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Cant. pend. recepción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Fecha de envío');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha de retorno WMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', '# Recepción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Cargado');

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ROWID  = $reg1 ['ROWID']; 
    $EPT  = $reg1 ['EPT']; 
    $ITEM  = $reg1 ['ITEM'];
    $CANTIDAD_TRANS  = number_format($reg1 ['CANTIDAD_ENV'], 0, ',', '');
    $CANTIDAD_RECEP  = number_format($reg1 ['CANTIDAD_REC'], 0, ',', '');
    $CANTIDAD_PEND_RECEP  = number_format($reg1 ['CANT_TRANS'], 0, ',', '');
    $FECHA_ENVIO  = $reg1 ['FECHA_ENVIO'];
    $FECHA_RETORNO  = $reg1 ['FECHA_RETORNO'];
    $RECEPCION  = $reg1 ['RECEPCION'];
    $CARGADO  = $reg1 ['CARGADO'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ROWID);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $EPT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $CANTIDAD_TRANS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CANTIDAD_REC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CANTIDAD_PEND_RECEP);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $FECHA_ENVIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $FECHA_RETORNO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $RECEPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $CARGADO);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':F'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('0'); 
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    

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












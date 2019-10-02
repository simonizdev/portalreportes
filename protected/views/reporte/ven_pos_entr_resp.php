<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model->fecha_inicial;
$fecha_final = $model->fecha_final;

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

$query ="
  EXEC [dbo].[COM_POS2_FONT]
  @FECHA_INI = N'".$FechaM1."',
  @FECHA_FIN = N'".$FechaM2."'
";

/*fin configuración array de datos*/

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'PEDIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'FECHA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'UND. MEDIDA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'EXISTENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'CANTIDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'PRECIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'VLR. NETO');

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$query1 = Yii::app()->db->createCommand($query)->queryAll();
    
$Fila = 2; 

foreach ($query1 as $reg1) {

  $PEDIDO           = $reg1 ['PEDIDO'];
  $CLIENTE          = $reg1 ['CLIENTE'];
  $FECHA            = $reg1 ['FECHA']; 
  $ITEM             = $reg1 ['ITEM']; 
  $DESCRIPCION      = $reg1 ['DESCRIPCION'];
  $UM               = $reg1 ['UM'];
  $EXISTENCIA       = $reg1 ['EXISTENCIA'];
  $CANTIDAD         = $reg1 ['CANTIDAD'];
  $PRECIO           = $reg1 ['PRECIO'];
  $VLR_NETO         = $reg1 ['VLR_NETO'];

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $PEDIDO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $CLIENTE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $FECHA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $ITEM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $DESCRIPCION);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $UM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $EXISTENCIA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $CANTIDAD);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $PRECIO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VLR_NETO);

  $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila.':J'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);       
  $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  $Fila = $Fila + 1;

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

$n = 'Ventas_POS_entrega_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
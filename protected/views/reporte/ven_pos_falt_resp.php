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
  EXEC [dbo].[COM_POS1_FONT]
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'FECHA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'EXISTENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'CANTIDAD');

$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$query1 = Yii::app()->db->createCommand($query)->queryAll();
    
$Fila = 2; 

foreach ($query1 as $reg1) {

  $FECHA            = $reg1 ['FECHA']; 
  $ITEM             = $reg1 ['ITEM']; 
  $DESCRIPCION      = $reg1 ['DESCRIPCION'];
  $EXISTENCIA       = $reg1 ['EXISTENCIA'];
  $CANTIDAD         = $reg1 ['CANTIDAD'];

  $cal = $EXISTENCIA - $CANTIDAD;

  if($cal < 0){

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $FECHA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $EXISTENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CANTIDAD);

    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':E'.$Fila)->getNumberFormat()->setFormatCode('0'); 
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);       
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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
  
$n = 'Ventas_POS_falt_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












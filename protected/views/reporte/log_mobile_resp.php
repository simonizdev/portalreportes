<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte
$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];

set_time_limit(0);

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);


/*inicio configuración array de datos*/

//EXCEL

$query ="
  EXEC [dbo].[COM_CONS_LOGMOBILE_FECHA]
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."'
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Documento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Fecha de elaboración');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Vendedor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Error');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Actualizado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Eliminado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha de registro');

$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $DOCUMENTO          = $reg1 ['DOCUMENTO']; 
    $FECHA_ELABORACION  = $reg1 ['FECHA_ELABORACION']; 
    $VENDEDOR  = $reg1 ['VENDEDOR'];
    $CLIENTE  = $reg1 ['CLIENTE'];
    $ERROR  = $reg1 ['ERROR'];
    $ACTUALIZADO  = $reg1 ['ACTUALIZADO'];
    $ELIMINADO  = $reg1 ['ELIMINADO'];
    $FECHA_REGISTRO  = $reg1 ['FECHA_REGISTRO'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $DOCUMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $FECHA_ELABORACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VENDEDOR);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $CLIENTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $ERROR);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $ACTUALIZADO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $ELIMINADO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $FECHA_REGISTRO);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Consulta_log_mobile_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












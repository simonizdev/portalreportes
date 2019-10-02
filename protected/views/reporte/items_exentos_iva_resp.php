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
  EXEC [dbo].[COM_CONS_CONT_ITEM_SIVA] 
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'DOCUMENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'RAZÓN SOCIAL CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'FECHA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'LINEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VALOR');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $Documento             = $reg1 ['Documento']; 
    $Razon_Social_Cliente  = $reg1 ['Razon_Social_Cliente']; 
    $Fecha                 = $reg1 ['Fecha'];
    $Linea                 = $reg1 ['LINEA'];
    $Item                  = $reg1 ['Item'];
    $Referencia            = $reg1 ['Referencia'];
    $Descripcion           = $reg1 ['Descripcion'];
    $Valor                 = $reg1 ['Valor'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $Documento);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Razon_Social_Cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $Fecha);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Linea);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Item);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Referencia);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Descripcion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Valor);
    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0');

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

$n = 'Items_exentos_iva_'.date('Y-m-d H_i_s'); 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

$tipo = $model['tipo'];
$cons_inicial = $model['cons_inicial'];
$cons_final = $model['cons_final'];

/*inicio configuración array de datos*/

//EXCEL

$query ="
  SELECT * FROM TH_FACTURA_ELECTRONICA WHERE FE_TIPO_DOCTO = '".$tipo."' AND FE_CONSECUTIVO BETWEEN ".$cons_inicial." AND ".$cons_final." ORDER BY FE_CONSECUTIVO
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Cia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'CO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Tipo de docto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Desc. tipo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Consecutivo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Cufe');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Fecha de factura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha de creación');

$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $cia  = $reg1 ['FE_CIA']; 
    $co  = $reg1 ['FE_CO']; 
    $tipo_docto  = $reg1 ['FE_TIPO_DOCTO']; 
    
    
    if($tipo_docto == "FVN") {
      $tipo = 'Factura de Venta Nacional';
    }

    if($tipo_docto == "FVX") {
      $tipo = 'Factura de Exportación';
    }

    if($tipo_docto == "FEC") {
      $tipo = 'Factura de Contingencia Facturador';
    }

    $consecutivo  = $reg1 ['FE_CONSECUTIVO']; 
    $cufe  = $reg1 ['FE_CUFE']; 
    $fecha_factura  = $reg1 ['FE_FECHA_FACTURA'];
    $fecha_creacion  = $reg1 ['CREACION']; 

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $cia);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $co);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $tipo_docto);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $tipo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $consecutivo); 
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $cufe);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $fecha_factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $fecha_creacion);
        
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

$n = 'Fact_elect_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












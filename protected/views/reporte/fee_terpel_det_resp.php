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
  EXEC [dbo].[COM_INF_FEE_TERPEL_DET] 
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CATEGORIA SSCC');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'PRODUCTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'LINEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'TIPO EDS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'RAZÓN SOCIAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'DIRECCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'FACTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'FECHA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'NIT');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'CIUDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'REGIONAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'NOMBRE EDS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'TOTAL UND.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'COSTO UND.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'TOTAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'TOTAL ANTES IVA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'VLR. FACT. FEE');
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $CATEGORIA_SSCC  = $reg1 ['CATEGORIA_SSCC']; 
    $PRODUCTO  = $reg1 ['PRODUCTO']; 
    $REFERENCIA  = $reg1 ['REFERENCIA'];
    $LINEA  = $reg1 ['LINEA'];
    $TIPO_EDS  = $reg1 ['TIPO_EDS'];
    $RAZON_SOCIAL  = $reg1 ['RAZON_SOCIAL'];
    $DIRECCION  = $reg1 ['DIRECCION'];
    $FACTURA  = $reg1 ['FACTURA'];
    $FECHA  = $reg1 ['FECHA']; 
    $NIT  = $reg1 ['NIT']; 
    $CIUDAD  = $reg1 ['CIUDAD'];
    $REGIONAL  = $reg1 ['REGIONAL'];
    $NOMBRE_EDS  = $reg1 ['NOMBRE_EDS'];
    $TOTAL_UND  = $reg1 ['TOTAL_UND'];
    $COSTO_UND  = $reg1 ['COSTO_UND'];
    $TOTAL  = $reg1 ['TOTAL'];
    $VLR_FACT_FEE_AIVA  = $reg1 ['VLR_FACT_FEE_AIVA'];
    $VLR_FACT_FEE  = $reg1 ['VLR_FACT_FEE']; 

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $CATEGORIA_SSCC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $PRODUCTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $LINEA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $TIPO_EDS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $RAZON_SOCIAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $DIRECCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $FACTURA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $FECHA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $NIT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $CIUDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $REGIONAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $NOMBRE_EDS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $TOTAL_UND);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $COSTO_UND);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $TOTAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $VLR_FACT_FEE_AIVA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $VLR_FACT_FEE);
    

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('O'.$Fila.':R'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('O'.$Fila.':R'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

$n = 'Fee_terpel_detallado_'.date('Y-m-d H_i_s'); 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












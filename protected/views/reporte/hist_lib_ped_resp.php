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
  EXEC [dbo].[COM_CONS_LIB_PED] 
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'PEDIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'FECHA PEDIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'NIT');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VLR. NETO PEDIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'VLR. BRUTO PEDIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'RET. X CUPO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'RET. X MORA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'RET. X MARGEN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'FECHA RETENIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'FECHA APROBACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'USUARIO APROB. CART.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'FECHA APROB. CART.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'USUARIO APROB. MARGEN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'FECHA APROB. MARGEN');
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $Pedido  = $reg1 ['Pedido']; 
    $Fch_Pedido  = $reg1 ['Fch_Pedido']; 
    $NIT  = $reg1 ['NIT'];
    $Cliente  = $reg1 ['Cliente'];
    $Vlr_Neto_Pedido  = $reg1 ['Vlr_Neto_Pedido'];
    $Vlr_Bruto_Pedido  = $reg1 ['Vlr_Bruto_Pedido'];
    $Ret_Cupo  = $reg1 ['Ret_Cupo'];
    $Ret_Mora  = $reg1 ['Ret_Mora'];
    $Ret_Margen  = $reg1 ['Ret_Margen']; 
    $Fch_Retenido  = $reg1 ['Fch_Retenido']; 
    $Fch_Aprobacion  = $reg1 ['Fch_Aprobacion'];
    $Usu_Apro_Cart  = $reg1 ['Usu_Apro_Cart'];
    $Fch_Apro_Cart  = $reg1 ['Fch_Apro_Cart'];
    $Usu_Apro_Marg  = $reg1 ['Usu_Apro_Marg'];
    $Fch_Apro_Marg  = $reg1 ['Fch_Apro_Marg'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $Pedido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Fch_Pedido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $NIT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Vlr_Neto_Pedido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Vlr_Bruto_Pedido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Ret_Cupo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Ret_Mora);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $Ret_Margen);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $Fch_Retenido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $Fch_Aprobacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $Usu_Apro_Cart);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $Fch_Apro_Cart);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $Usu_Apro_Marg);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $Fch_Apro_Marg);
    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':F'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Historico_liberacion_pedidos_'.date('Y-m-d H_i_s'); 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












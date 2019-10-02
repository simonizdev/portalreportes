<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="
  SELECT DISTINCT 
  t1.Rowid AS Rowid
  ,Descr_Msj AS Banco
  ,Num_Ident AS Nit_Cliente
  ,Nom_Cliente AS Cliente
  ,Referencia AS Factura
  ,Num_Fact AS Numero_Factura
  ,Mod_Pago AS Medio_Pago
  ,Estado AS Estado
  ,Valor_Pago AS Valor
  ,Cus AS Referencia_Pago
  ,ts_fecha AS Fecha_Reporte 
  ,CASE WHEN ISNULL(INTEGRADO,0) = 0 THEN 'SIN REPORTE' WHEN ISNULL(INTEGRADO,0)=1 THEN 'PENDIENTE' WHEN ISNULL(INTEGRADO,0)=2 THEN 'CARGADO' END AS Reportado
  from Pagos_Inteligentes..T_PSE AS t1
  LEFT JOIN [Repositorio_Datos].[dbo].[T_IN_Recibos_Caja] AS t2 ON t1.Id_Cliente = t2.F350_ID_TERCERO AND t1.Cus = t2.F357_REFERENCIA AND t1.Referencia = t2.F350_NOTAS
  ORDER BY 1 DESC
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
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Banco');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Nit');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Factura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', '# Factura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Medio de pago');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Estado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Valor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Ref. pago');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Fecha reporte');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Reportado');

$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $Rowid  = $reg1 ['Rowid']; 
    $Banco  = $reg1 ['Banco']; 
    $Nit_Cliente  = $reg1 ['Nit_Cliente']; 
    $Cliente  = $reg1 ['Cliente']; 
    $Factura  = $reg1 ['Factura']; 
    $Numero_Factura  = $reg1 ['Numero_Factura']; 
    $Medio_Pago  = $reg1 ['Medio_Pago']; 
    $Estado  = $reg1 ['Estado']; 
    $Valor  = $reg1 ['Valor'];
    $Referencia_Pago  = $reg1 ['Referencia_Pago']; 
    $Fecha_Reporte  = $reg1 ['Fecha_Reporte']; 
    $Reportado  = $reg1 ['Reportado']; 

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $Rowid);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Banco);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $Nit_Cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Numero_Factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Medio_Pago);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Estado);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $Valor);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $Referencia_Pago);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $Fecha_Reporte);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $Reportado);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila.':L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Consulta_pagos_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>












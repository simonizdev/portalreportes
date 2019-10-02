<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);
ini_set('memory_limit','10240M');

//se reciben los parametros para el reporte
$fecha_inicial = $model->fecha_inicial;
$fecha_final = $model->fecha_final;
$marca = trim($model->marca);

//opcion: 1. PDF, 2. EXCEL
$opcion = $model->opcion_exp;

//se obtiene la cadena de la fecha actual
$diatxt=date('l');
$dianro=date('d');
$mestxt=date('F');
$anionro=date('Y');
// *********** traducciones y modificaciones de fechas a letras y a español ***********
$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$diaesp=str_replace($ding, $desp, $diatxt);
$mesesp=str_replace($ming, $mesp, $mestxt);

$fecha_act= $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

$query= "
EXEC [dbo].[COM_CONS_VENT_ITEM]
    @FECHA1 = N'".$FechaM1."',
    @FECHA2 = N'".$FechaM2."',
    @I_CRI_MARCA = N'".$marca."'
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:AB1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Criterio de búsqueda: Fecha del '.$fecha_inicial.' al '.$fecha_final.', Marca: '.$marca);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A3', 'CO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B3', 'FECHA MOVTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C3', 'DOCUMENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D3', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E3', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F3', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G3', 'UN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H3', 'MARCA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I3', 'LINEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J3', 'SUB-LINEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K3', 'ORACLE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L3', 'DESCUENTO PROM.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M3', 'PRECIO 560');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N3', 'MARGEN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O3', 'CANTIDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P3', 'VLR BRUTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q3', 'VLR DESCUENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R3', 'VLR SUBTOTAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S3', 'VLR IMPUESTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T3', 'VLR NETO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U3', 'UTIL. PROM.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V3', 'CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W3', 'ESTRUCTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X3', 'SEGMENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y3', 'RUTA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z3', 'VENDEDOR');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA3', 'CIUDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB3', 'DIRECCIÓN');

$objPHPExcel->getActiveSheet()->getStyle('A3:AB3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:AB3')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$query1 = Yii::app()->db->createCommand($query)->queryAll();
 
$Fila = 4;  

foreach ($query1 as $reg1) {
  
  $CO               = $reg1 ['CO'];
  $FECHA_MOVTO        = $reg1 ['FECHA_MOVTO'];
  $DOCUMENTO        = $reg1 ['DOCUMENTO'];   
  $ITEM              = $reg1 ['ITEM'];   
  $DESCRIPCION             = $reg1 ['DESCRIPCION']; 
  $REFERENCIA           = $reg1 ['REFERENCIA']; 
  $UN           = $reg1 ['UN'];  
  $MARCA         = $reg1 ['MARCA']; 
  $LINEA          = $reg1 ['LINEA'];  
  $SUBLINEA         = $reg1 ['SUBLINEA'];
  $ORACLE           = $reg1 ['ORACLE'];    
  $DESCUENTO_PROM         = $reg1 ['DESCUENTO_PROM']; 
  $PRECIO_560          = $reg1 ['PRECIO_560']; 
  $MARGEN           = $reg1 ['MARGEN']; 
  $CANTIDAD                = $reg1 ['CANTIDAD']; 
  $VLR_BRUTO       = $reg1 ['VLR_BRUTO']; 
  $VLR_DESCUENTO       = $reg1 ['VLR_DESCUENTO'];
  $VLR_SUBTOTAL       = $reg1 ['VLR_SUBTOTAL'];
  $VLR_IMPUESTO       = $reg1 ['VLR_IMPUESTO'];
  $VLR_NETO       = $reg1 ['VLR_NETO'];
  $UTIL_PROM       = $reg1 ['UTIL_PROM'];
  $CLIENTE       = $reg1 ['CLIENTE'];
  $ESTRUCTURA       = $reg1 ['ESTRUCTURA'];
  $SEGMENTO       = $reg1 ['SEGMENTO']; 
  $RUTA       = $reg1 ['RUTA']; 
  $VENDEDOR       = $reg1 ['VENDEDOR']; 
  $CIUDAD       = $reg1 ['CIUDAD']; 
  $DIRECCION       = $reg1 ['DIRECCION']; 

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $CO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $FECHA_MOVTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $DOCUMENTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $ITEM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $DESCRIPCION);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $REFERENCIA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $UN);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $MARCA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $LINEA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $SUBLINEA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ORACLE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $DESCUENTO_PROM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $PRECIO_560);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $MARGEN);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $CANTIDAD);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $VLR_BRUTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $VLR_DESCUENTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $VLR_SUBTOTAL);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $VLR_IMPUESTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $VLR_NETO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $UTIL_PROM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $CLIENTE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ESTRUCTURA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $SEGMENTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $RUTA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $VENDEDOR);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $CIUDAD);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $DIRECCION);


  $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila.':U'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila.':U'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('V'.$Fila.':AB'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Revision_comercial_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>

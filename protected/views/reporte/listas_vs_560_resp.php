<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$marca = $model['marca'];
$lista = $model['lista'];
$estado = $model['estado'];

/*inicio configuración array de datos*/

$query= "
    EXEC [dbo].[COM_CONS_LISTAS_VS_560]
    @ESTADO = N'".$estado."',
    @MARCA = N'".$marca."',
    @LISTA = N'".$lista."'
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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CÓDIGO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'CÓDIGO DE BARRAS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'ESTADO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'PRECIO LISTA 560');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'PRECIO LISTA '.$lista);
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'PRECIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'FECHA VCTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'INSTALACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'INVENTARIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'TIPO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'UND. COMPRA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'STOCK MESES');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'UNIDAD DE NEGOCIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'ORIGEN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'TIPO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'cLASIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'CLASE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'MARCA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'SEGMENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'LÍNEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'SUB-LÍNEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'UNIDAD DE NEGOCIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'ORACLE');

$objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$query1 = Yii::app()->db->createCommand($query)->queryAll();
 
$Fila = 2;  

foreach ($query1 as $reg1) {

  $ITEM                = $reg1 ['ITEM'];
  $DESCRIPCION         = $reg1 ['I_DESCRIPCION'];
  $REFERENCIA          = $reg1 ['I_REFERENCIA'];

  if($reg1 ['I_CODIGO_BARRAS'] == NULL){
    $CODIGO_BARRAS = 'NO APLICA';
  }else{
    $CODIGO_BARRAS = $reg1 ['I_CODIGO_BARRAS'];
  }

  $ESTADO              = $reg1 ['I_ESTADO'];

  if($reg1 ['PRECIO1'] == NULL){
    $PRECIO1 = 0;
  }else{
    $PRECIO1 = $reg1 ['PRECIO1'];
  }

  if($reg1 ['PRECIO2'] == NULL){
    $PRECIO2 = 0;
  }else{
    $PRECIO2 = $reg1 ['PRECIO2'];
  }

  if($reg1 ['I_PRECIO'] == NULL){
    $PRECIO = 0;
  }else{
    $PRECIO = $reg1 ['I_PRECIO'];
  }

  if($reg1 ['FCH_VCTO'] == NULL){
    $FCH_VCTO = 'NO APLICA';
  }else{
    $FCH_VCTO = $reg1 ['FCH_VCTO'];
  }

  if($reg1 ['I_INSTALACION'] == NULL){
    $INSTALACION = 'NO APLICA';
  }else{
    $INSTALACION = $reg1 ['I_INSTALACION'];
  }

  if($reg1 ['I_INVENTARIO'] == NULL){
    $INVENTARIO = 'NO APLICA';
  }else{
    $INVENTARIO = $reg1 ['I_INVENTARIO'];
  }

  if($reg1 ['I_TIPO'] == NULL){
    $TIPO = 'NO APLICA';
  }else{
    $TIPO = $reg1 ['I_TIPO'];
  }

  if($reg1 ['I_LOTE'] == NULL){
    $UND_COMPRA = 0;
  }else{
    $UND_COMPRA = $reg1 ['I_LOTE'];
  }

  if($reg1 ['I_STOCK'] == NULL){
    $STOCK_MESES = 0;
  }else{
    $STOCK_MESES = $reg1 ['I_STOCK'];
  }

  if($reg1 ['I_UNIDAD_NEGOCIO'] == NULL){
    $UN = 'NO APLICA';
  }else{
    $UN = $reg1 ['I_UNIDAD_NEGOCIO'];
  }

  if($reg1 ['I_CRI_ORIGEN'] == NULL){
    $ORIGEN = 'NO APLICA';
  }else{
    $ORIGEN = $reg1 ['I_CRI_ORIGEN'];
  }

  if($reg1 ['I_CRI_TIPO'] == NULL){
    $CRI_TIPO = 'NO APLICA';
  }else{
    $CRI_TIPO = $reg1 ['I_CRI_TIPO'];
  }

  if($reg1 ['I_CRI_CLASIFICACION'] == NULL){
    $CLASIFICACION = 'NO APLICA';
  }else{
    $CLASIFICACION = $reg1 ['I_CRI_CLASIFICACION'];
  }

  if($reg1 ['I_CRI_CLASE'] == NULL){
    $CLASE = 'NO APLICA';
  }else{
    $CLASE = $reg1 ['I_CRI_CLASE'];
  }

  if($reg1 ['I_CRI_MARCA'] == NULL){
    $MARCA = 'NO APLICA';
  }else{
    $MARCA = $reg1 ['I_CRI_MARCA'];
  }

  if($reg1 ['I_CRI_SEGMENTO'] == NULL){
    $SEGMENTO = 'NO APLICA';
  }else{
    $SEGMENTO = $reg1 ['I_CRI_SEGMENTO'];
  }

  if($reg1 ['I_CRI_LINEA'] == NULL){
    $LINEA = 'NO APLICA';
  }else{
    $LINEA = $reg1 ['I_CRI_LINEA'];
  }

  if($reg1 ['I_CRI_SUBLINEA'] == NULL){
    $SUBLINEA = 'NO APLICA';
  }else{
    $SUBLINEA = $reg1 ['I_CRI_SUBLINEA'];
  }

  if($reg1 ['I_CRI_UNIDAD_NEGOCIO'] == NULL){
    $CRI_UNIDAD_NEGOCIO = 'NO APLICA';
  }else{
    $CRI_UNIDAD_NEGOCIO = $reg1 ['I_CRI_UNIDAD_NEGOCIO'];
  }

  if($reg1 ['I_CRI_ORACLE'] == NULL){
    $ORACLE = 'NO APLICA';
  }else{
    $ORACLE = $reg1 ['I_CRI_ORACLE'];
  }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ITEM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, substr($REFERENCIA,0,20));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, substr($DESCRIPCION,0,40));
  $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$Fila, $CODIGO_BARRAS, PHPExcel_Cell_DataType::TYPE_STRING);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, substr($ESTADO, 0, 8));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PRECIO1);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $PRECIO2);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $PRECIO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $FCH_VCTO);
  $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$Fila, $INSTALACION, PHPExcel_Cell_DataType::TYPE_STRING);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $INVENTARIO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $TIPO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $UND_COMPRA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $STOCK_MESES);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $UN);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $ORIGEN);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $CRI_TIPO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $CLASIFICACION);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $CLASE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $MARCA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $SEGMENTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $LINEA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $SUBLINEA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $CRI_UNIDAD_NEGOCIO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $ORACLE);

  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getNumberFormat()->setFormatCode('#,#0.0');
  $objPHPExcel->getActiveSheet()->getStyle('O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Lista_'.$lista.'_VS_560_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











